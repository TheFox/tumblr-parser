<?php

namespace TheFox\Tumblr;

use RuntimeException;
use DateTime;
//use ReflectionClass;
use Symfony\Component\Yaml\Yaml;
use TheFox\Tumblr\Element\Element;
use TheFox\Tumblr\Element\AskEnabledBlockElement;
use TheFox\Tumblr\Element\AudioBlockElement;
use TheFox\Tumblr\Element\AudioEmbedBlockElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Element\DateBlockElement;
use TheFox\Tumblr\Element\DescriptionBlockElement;
use TheFox\Tumblr\Element\HasPagesBlockElement;
use TheFox\Tumblr\Element\HasTagsBlockElement;
use TheFox\Tumblr\Element\HtmlElement;
use TheFox\Tumblr\Element\IfBlockElement;
use TheFox\Tumblr\Element\IfNotBlockElement;
use TheFox\Tumblr\Element\IndexPageBlockElement;
use TheFox\Tumblr\Element\LabelBlockElement;
use TheFox\Tumblr\Element\LinkUrlBlockElement;
use TheFox\Tumblr\Element\NextPageBlockElement;
use TheFox\Tumblr\Element\NoteCountBlockElement;
use TheFox\Tumblr\Element\PagesBlockElement;
use TheFox\Tumblr\Element\PaginationBlockElement;
use TheFox\Tumblr\Element\PermalinkPageBlockElement;
use TheFox\Tumblr\Element\PostNotesBlockElement;
use TheFox\Tumblr\Element\PostsBlockElement;
use TheFox\Tumblr\Element\PostTitleBlockElement;
use TheFox\Tumblr\Element\PreviousPageBlockElement;
use TheFox\Tumblr\Element\SourceBlockElement;
use TheFox\Tumblr\Element\TagsBlockElement;
use TheFox\Tumblr\Element\TitleBlockElement;
use TheFox\Tumblr\Element\VideoBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\TextVariableElement;
use TheFox\Tumblr\Element\LangVariableElement;
use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Element\Post\PhotoBlockElement;
use TheFox\Tumblr\Element\Post\PhotosBlockElement;
use TheFox\Tumblr\Element\Post\PhotosetBlockElement;
use TheFox\Tumblr\Element\Post\QuoteBlockElement;
use TheFox\Tumblr\Element\Post\ChatBlockElement;
use TheFox\Tumblr\Element\Post\LinesBlockElement;
use TheFox\Tumblr\Element\Post\AnswerBlockElement;
use TheFox\Tumblr\Post\Post;
use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;
use TheFox\Tumblr\Post\PhotoPost;
#use TheFox\Tumblr\Post\PhotosPost;
use TheFox\Tumblr\Post\PhotosetPost;
use TheFox\Tumblr\Post\QuotePost;
use TheFox\Tumblr\Post\ChatPost;
use TheFox\Tumblr\Post\AnswerPost;

class Parser
{
    const VERSION = '0.6.0';

    public static $variableNames = [
        '12Hour',
        '12HourWithZero',
        '24Hour',
        '24HourWithZero',
        'Alt',
        'AmPm',
        'Answer',
        'Asker',
        'AskLabel',
        'Body',
        'CapitalAmPm',
        'Caption',
        'CustomCSS',
        'DayOfMonth',
        'DayOfMonthSuffix',
        'DayOfMonthWithZero',
        'DayOfWeek',
        'DayOfWeekNumber',
        'DayOfYear',
        'Description',
        'Label',
        'Length',
        'LikeButton',
        'Line',
        'LinkCloseTag',
        'LinkOpenTag',
        'LinkURL',
        'MetaDescription',
        'Minutes',
        'Month',
        'MonthNumber',
        'MonthNumberWithZero',
        'Name',
        'NextPage',
        'NoteCount',
        'NoteCountWithLabel',
        'Permalink',
        'PhotoAlt',
        'PhotoURL-500',
        'PostID',
        'PostNotes',
        'PostTitle',
        'PreviousPage',
        'Question',
        'Quote',
        'ReblogButton',
        'Seconds',
        'ShortDayOfWeek',
        'ShortMonth',
        'ShortYear',
        'Source',
        'Tag',
        'TagURL',
        'Target',
        'Timestamp',
        'Title',
        'URL',
        'UserNumber',
        'WeekOfYear',
        'Year',
    ];

    /**
     * @var array
     */
    private $settings = [];

    /**
     * @var string
     */
    private $template = '';

    /**
     * @var bool
     */
    private $templateChanged = false;

    /**
     * @var int
     */
    private $variablesId = 0;

    /**
     * @var array
     */
    private $variables = [];

    /**
     * @var Element
     */
    private $rootElement;

    /**
     * @var int
     */
    private $elementsId = 0;

    /**
     * Parser constructor.
     * @param string $template
     */
    public function __construct(string $template = '')
    {
        $this->template = $template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;
        $this->templateChanged = true;
    }

    /**
     * @param array $settings
     */
    public function setSettings(array $settings)
    {
        if (!isset($settings['vars']) || !is_array($settings['vars'])) {
            throw new RuntimeException(__FUNCTION__ . ': "vars" not set in settings.', 1);
        }
        if (!isset($settings['posts']) || !is_array($settings['posts'])) {
            throw new RuntimeException(__FUNCTION__ . ': "posts" not set in settings.', 2);
        }
        if (!isset($settings['postsPerPage'])) {
            throw new RuntimeException(__FUNCTION__ . ': "postsPerPage" not set in settings.', 3);
        }
        if (!isset($settings['pages'])) {
            throw new RuntimeException(__FUNCTION__ . ': "pages" not set in settings.', 4);
        }

        $this->settings = $settings;

        $this->parseSettingsVars();
    }

    /**
     * @param string $file
     */
    public function loadSettingsFromFile(string $file)
    {
        $settings = Yaml::parse($file);
        $this->setSettings($settings);
    }

    /**
     * @param array $variables
     * @param bool $overwrite
     */
    private function fillVariables(array $variables, bool $overwrite = false)
    {
        foreach ($variables as $key => $val) {
            $this->variablesId++;
            $variable = new Variable();
            $variable->setId($this->variablesId);
            $variable->setName($key);
            $variable->setValue($val);

            $tmpName = $variable->getTemplateName();
            $ifName = $variable->getIfName();
            $ifNotName = $variable->getIfNotName();

            if ($overwrite || !$overwrite && !isset($this->variables[$tmpName])) {
                $this->variables[$tmpName] = $variable;

                $variableIf = clone $variable;
                if ($tmpName != $ifName) {
                    #$variableIf->setReference($variable);
                    $this->variablesId++;
                    $variableIf->setId($this->variablesId);
                    $variableIf->setValue((bool)$val);
                    $this->variables[$ifName] = $variableIf;
                }

                $variableIfNot = clone $variableIf;
                #$variableIfNot->setReference($variableIf);
                $this->variablesId++;
                $variableIfNot->setId($this->variablesId);
                $variableIfNot->setValue(!$variableIfNot->getValue());
                $this->variables[$ifNotName] = $variableIfNot;


            }
        }
    }

    private function parseSettingsVars()
    {
        $this->fillVariables($this->settings['vars'], true);
    }

    private function parseMetaSettings()
    {
        foreach (['if', 'text'] as $type) {
            preg_match_all('/<meta name="(' . $type . ':[^"]+)" content="([^"]+)"/i', $this->template, $matches);
            $variables = [];
            if ($matches[1] && $matches[2]) {
                $variables = array_combine($matches[1], $matches[2]);
            }
            $this->fillVariables($variables);
        }
    }

    /**
     * @param string $rawhtml
     * @param Element|null $parentElement
     * @param int $level
     */
    private function parseElements(string $rawhtml = '', Element $parentElement = null, int $level = 1)
    {
        if ($level >= 100) {
            throw new RuntimeException(__FUNCTION__ . ': Maximum level of 100 reached.', 2);
        }

        if (!$rawhtml && $level == 1) {
            $rawhtml = $this->template;
        }
        if (!$parentElement) {
            $this->elementsId++;
            $parentElement = new Element();
            $parentElement->setId($this->elementsId);

            $this->rootElement = $parentElement;
        }

        $fuse = 0;
        while ($rawhtml) {
            $fuse++;
            if ($fuse >= 1000) {
                throw new RuntimeException(__FUNCTION__ . ': Maximum level of 1000 reached.', 3);
            }

            $content = '';
            $element = null;

            // Find opening bracket.
            $pos = strpos($rawhtml, '{');
            if ($pos === false) {
                $this->elementsId++;
                $element = new HtmlElement();
                $element->setId($this->elementsId);
                $element->setContent($rawhtml);
                $parentElement->addChild($element);

                $rawhtml = '';
            } else {
                if ($pos >= 1) {
                    $content = substr($rawhtml, 0, $pos);
                }

                $this->elementsId++;
                $element = new HtmlElement();
                $element->setId($this->elementsId);
                $element->setContent($content);
                $parentElement->addChild($element);

                $rawhtml = substr($rawhtml, $pos + 1);

                // Find close bracket for the opening one.
                $pos = strpos($rawhtml, '}');
                if ($pos === false) {

                    $content .= '{';

                    $element->setContent($content);
                } else {
                    $nameFull = substr($rawhtml, 0, $pos);
                    $nameFullLen = strlen($nameFull);
                    $rawhtml = substr($rawhtml, $pos + 1);


                    if (strtolower(substr($nameFull, 0, 6)) == 'block:') {
                        // Process a block element.

                        $nameFullPos = strpos($nameFull, ':');
                        $name = substr($nameFull, $nameFullPos + 1);
                        $type = strtolower(substr($nameFull, 0, $nameFullPos));

                        // Search close tag for the opened tag.
                        $offset = 0;
                        //$newoffset = 0;
                        //$testhtml = '';
                        $temphtml = $rawhtml;
                        do {
                            $temphtml = substr($temphtml, $offset);
                            $pos = strpos($temphtml, '{/' . $nameFull . '}');

                            if ($pos === false) {
                                throw new RuntimeException(__FUNCTION__ . ': Missing closing tag "{/' . $nameFull . '}".', 1);
                            } else {
                                $testhtml = substr($temphtml, 0, $pos);
                                $newoffset = $offset + $pos + 2 + $nameFullLen + 1;

                                $offset = $newoffset;
                            }
                        } while (strpos($testhtml, '{' . $nameFull . '}') !== false);

                        $subhtml = substr($rawhtml, 0, $offset - 2 - $nameFullLen - 1);
                        $rawhtml = substr($rawhtml, $offset);

                        $element = null;
                        if ($type == 'block') {
                            if (strtolower(substr($name, 0, 5)) == 'ifnot') {
                                $name = substr($name, 5);
                                $element = new IfNotBlockElement();
                            } elseif (strtolower(substr($name, 0, 2)) == 'if') {
                                $name = substr($name, 2);
                                $element = new IfBlockElement();
                            } elseif ($name == 'Posts') {
                                $element = new PostsBlockElement();
                            } elseif ($name == 'Text') {
                                $element = new TextBlockElement();
                            } elseif ($name == 'Link') {
                                $element = new LinkBlockElement();
                            } elseif ($name == 'Photo') {
                                $element = new PhotoBlockElement();
                            } elseif ($name == 'Photos') {
                                $element = new PhotosBlockElement();
                            } elseif ($name == 'Photoset') {
                                $element = new PhotosetBlockElement();
                            } elseif ($name == 'IndexPage') {
                                $element = new IndexPageBlockElement();
                            } elseif ($name == 'PermalinkPage') {
                                $element = new PermalinkPageBlockElement();
                            } elseif ($name == 'Title') {
                                $element = new TitleBlockElement();
                            } elseif ($name == 'PostTitle') {
                                $element = new PostTitleBlockElement();
                            } elseif ($name == 'Description') {
                                $element = new DescriptionBlockElement();
                            } elseif ($name == 'AskEnabled') {
                                $element = new AskEnabledBlockElement();
                            } elseif ($name == 'HasPages') {
                                $element = new HasPagesBlockElement();
                            } elseif ($name == 'Pages') {
                                $element = new PagesBlockElement();
                            } elseif ($name == 'Caption') {
                                $element = new CaptionBlockElement();
                            } elseif ($name == 'Quote') {
                                $element = new QuoteBlockElement();
                            } elseif ($name == 'Chat') {
                                $element = new ChatBlockElement();
                            } elseif ($name == 'Audio') {
                                $element = new AudioBlockElement();
                            } elseif ($name == 'Video') {
                                $element = new VideoBlockElement();
                            } elseif ($name == 'Answer') {
                                $element = new AnswerBlockElement();
                            } elseif ($name == 'Source') {
                                $element = new SourceBlockElement();
                            } elseif ($name == 'Lines') {
                                $element = new LinesBlockElement();
                            } elseif ($name == 'Label') {
                                $element = new LabelBlockElement();
                            } elseif ($name == 'Date') {
                                $element = new DateBlockElement();
                            } elseif ($name == 'AudioEmbed') {
                                $element = new AudioEmbedBlockElement();
                            } elseif ($name == 'NoteCount') {
                                $element = new NoteCountBlockElement();
                            } elseif ($name == 'HasTags') {
                                $element = new HasTagsBlockElement();
                            } elseif ($name == 'PostNotes') {
                                $element = new PostNotesBlockElement();
                            } elseif ($name == 'Pagination') {
                                $element = new PaginationBlockElement();
                            } elseif ($name == 'PreviousPage') {
                                $element = new PreviousPageBlockElement();
                            } elseif ($name == 'NextPage') {
                                $element = new NextPageBlockElement();
                            } elseif ($name == 'Tags') {
                                $element = new TagsBlockElement();
                            } elseif ($name == 'LinkURL') {
                                $element = new LinkUrlBlockElement();
                            } else {
                                $msg = __FUNCTION__ . ': Unknown block "' . $name . '". Path: ' . $parentElement->getPath();
                                throw new RuntimeException($msg, 3);
                            }
                        }
                        if ($element) {
                            $this->elementsId++;
                            $element->setId($this->elementsId);
                            $element->setName($name);
                            $parentElement->addChild($element);

                            $this->parseElements($subhtml, $element, $level + 1);
                        }
                        /*else{
                            throw new RuntimeException(__FUNCTION__.': Can not create element.', 4);
                        }*/
                    } else {
                        // Process non-block element.
                        #fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'else'.PHP_EOL);

                        if (in_array($nameFull, static::$variableNames)) {
                            $this->elementsId++;
                            $element = new VariableElement();
                            $element->setId($this->elementsId);
                            $element->setName($nameFull);
                            $parentElement->addChild($element);
                        } elseif (substr($nameFull, 0, 5) == 'text:') {
                            $this->elementsId++;
                            $element = new TextVariableElement();
                            $element->setId($this->elementsId);
                            $element->setName($nameFull);
                            $parentElement->addChild($element);
                        } elseif (substr($nameFull, 0, 5) == 'lang:') {

                            $this->elementsId++;
                            $element = new LangVariableElement();
                            $element->setId($this->elementsId);
                            $element->setName($nameFull);
                            $parentElement->addChild($element);
                        } else {
                            // Unknown block. Set the original content.

                            $content = '{' . $nameFull . '}';

                            $this->elementsId++;
                            $element = new HtmlElement();
                            $element->setId($this->elementsId);
                            $element->setName($nameFull);
                            $element->setContent($content);
                            $parentElement->addChild($element);
                        }
                    }
                }

            }
        }
    }

    /**
     * @param Element $element
     * @param bool $isIndexPage
     * @param bool $isPermalinkPage
     * @param array $posts
     * @param int $id
     * @param int $totalPages
     * @param array $pages
     * @param int $level
     */
    private function setElementsValues(Element $element = null, bool $isIndexPage = false, bool $isPermalinkPage = false,
                                       array $posts = [], int $id = 1, int $totalPages = 1, array $pages = [], int $level = 1)
    {
        if ($level >= 100) {
            throw new RuntimeException(__FUNCTION__ . ': Maximum level of 100 reached.', 1);
        }

        if ($element == null) {
            return;
        }

        $elemtents = $element->getChildren();
        foreach ($elemtents as $elementId => $element) {
            $elementName = $element->getTemplateName();

            //$elementNameOut = '';
            //if ($elementName) {
            //    $elementNameOut = ', "' . $elementName . '"';
            //}

            //$rc = new ReflectionClass(get_class($element));
            //$className = $rc->getShortName();

            $setSub = true;
            if ($element instanceof VariableElement) {
                $content = $element->getDefaultContent();
                if ($element instanceof LangVariableElement) {
                    if ($isIndexPage && $elementName == 'lang:Page CurrentPage of TotalPages') {
                        $content = 'Page ' . $id . ' of ' . $totalPages;
                    } else {
                        if (isset($this->variables[$elementName])) {
                            $content = $this->variables[$elementName]->getValue();
                        }
                    }
                } elseif ($elementName == 'PreviousPage') {
                    if ($isIndexPage && $id > 1) {
                        $content = '?type=page&id=' . ($id - 1);
                        #$element->setContent($url);
                    }
                } elseif ($elementName == 'NextPage') {
                    if ($isIndexPage && $id < $totalPages) {
                        $content = '?type=page&id=' . ($id + 1);
                        #$element->setContent($url);
                    }
                }

                if (!$content && isset($this->variables[$elementName])) {
                    $content = $this->variables[$elementName]->getValue();
                }

                $element->setContent($content);
                $setSub = false;
            } elseif ($element instanceof IndexPageBlockElement) {
                $element->setContent($isIndexPage);
            } elseif ($element instanceof PermalinkPageBlockElement) {
                $element->setContent($isPermalinkPage);
            } elseif ($element instanceof PostTitleBlockElement) {
                $element->setContent($isPermalinkPage);
            } elseif ($element instanceof IfNotBlockElement) {
                if (isset($this->variables[$elementName])) {
                    $val = (bool)$this->variables[$elementName]->getValue();
                    $element->setContent($val);
                } else {
                    $element->setContent($element->getDefaultContent());
                }
            } elseif ($element instanceof IfBlockElement) {
                if (isset($this->variables[$elementName])) {
                    $val = (bool)$this->variables[$elementName]->getValue();
                    $element->setContent($val);
                } else {
                    $element->setContent($element->getDefaultContent());
                }
            } elseif ($element instanceof AskEnabledBlockElement) {
                $elementName = 'IfAskEnabled';
                if (isset($this->variables[$elementName])) {
                    $element->setContent(true);
                } else {
                    $element->setContent($element->getDefaultContent());
                }
            } elseif ($element instanceof DescriptionBlockElement) {
                $elementName = 'MetaDescription';
                if (isset($this->variables[$elementName])) {
                    $element->setContent(true);
                } else {
                    $element->setContent($element->getDefaultContent());
                }
            } elseif ($element instanceof PaginationBlockElement) {
                $element->setContent($isIndexPage);
            } elseif ($element instanceof PreviousPageBlockElement) {
                if ($isIndexPage && $id > 1) {
                    $element->setContent(true);
                }
            } elseif ($element instanceof NextPageBlockElement) {
                if ($isIndexPage && $id < $totalPages) {
                    $element->setContent(true);
                }
            } elseif ($element instanceof HasPagesBlockElement) {
                $element->setContent(count($pages) > 0);
            } elseif ($element instanceof PagesBlockElement) {
                $element->setContent($pages);
            } elseif ($element instanceof PostsBlockElement) {
                $element->setContent($posts);
            }

            if ($setSub) {
                $this->setElementsValues($element, $isIndexPage, $isPermalinkPage, $posts, $id, $totalPages, $pages, $level + 1);
            }
        }
    }

    /**
     * @param Element $element
     * @return string
     */
    private function renderElements(Element $element = null): string
    {
        if (!$element) {
            return '';
        }

        return $element->render();
    }

    /**
     * @param array $post
     * @return PhotoPost
     */
    private function makePhoto(array $post): PhotoPost
    {
        $postObj = new PhotoPost();
        if (isset($post['url'])) {
            $postObj->setUrl($post['url']);
        }
        if (isset($post['alt'])) {
            $postObj->setAlt($post['alt']);
        }
        if (isset($post['link'])) {
            $postObj->setLinkUrl($post['link']);
        }
        if (isset($post['caption'])) {
            $postObj->setCaption($post['caption']);
        }

        return $postObj;
    }

    /**
     * @param int $id
     * @param bool $isPermalinkPage
     * @return null|Post
     */
    private function makePostFromIndex(int $id, bool $isPermalinkPage = false)
    {
        if (!isset($this->settings['posts'][$id])) {
            return null;
        }

        $htmlId = $id + 1;
        $post = $this->settings['posts'][$id];
        $type = strtolower($post['type']);

        $postObj = null;
        if ($type == 'text') {
            $postObj = new TextPost();
            if (isset($post['title'])) {
                $postObj->setTitle($post['title']);
            }
            if (isset($post['body'])) {
                $postObj->setBody($post['body']);
            }
        } elseif ($type == 'link') {
            $postObj = new LinkPost();
            if (isset($post['url'])) {
                $postObj->setUrl($post['url']);
            }
            if (isset($post['name'])) {
                $postObj->setName($post['name']);
            }
            if (isset($post['target'])) {
                $postObj->setTarget($post['target']);
            }
            if (isset($post['description'])) {
                $postObj->setDescription($post['description']);
            }
        } elseif ($type == 'photo') {
            $postObj = $this->makePhoto($post);
        } elseif ($type == 'photoset') {
            $postObj = new PhotosetPost();
            if (isset($post['caption'])) {
                $postObj->setCaption($post['caption']);
            }
            if (isset($post['photos'])) {
                $photos = [];
                foreach ($post['photos'] as $photo) {
                    $photoObj = $this->makePhoto($photo);
                    if ($photoObj) {
                        $photos[] = $photoObj;
                    }
                }
                $postObj->setPhotos($photos);
            }
        } elseif ($type == 'quote') {
            $postObj = new QuotePost();
            if (isset($post['quote'])) {
                $postObj->setQuote($post['quote']);
            }
            if (isset($post['source'])) {
                $postObj->setSource($post['source']);
            }
            if (isset($post['length'])) {
                $postObj->setLength($post['length']);
            }
        } elseif ($type == 'chat') {
            $postObj = new ChatPost();
            if (isset($post['title'])) {
                $postObj->setTitle($post['title']);
            }
            if (isset($post['chats'])) {
                $postObj->setChats($post['chats']);
            }
        } elseif ($type == 'answer') {
            $postObj = new AnswerPost();
            if (isset($post['asker'])) {
                $postObj->setAsker($post['asker']);
            }
            if (isset($post['question'])) {
                $postObj->setQuestion($post['question']);
            }
            if (isset($post['answer'])) {
                $postObj->setAnswer($post['answer']);
            }
        }

        if ($postObj) {
            if (isset($post['permalink'])) {
                $postObj->setPermalink($post['permalink']);
            } else {
                $postObj->setPermalink('?type=post&id=' . $htmlId);
            }
            if (isset($post['date'])) {
                $postDateTime = new DateTime($post['date']);
                $postObj->setDateTime($postDateTime);
            }
            if (isset($post['notes'])) {
                $postObj->setNotes($post['notes']);
            }
            if (isset($post['tags'])) {
                $postObj->setTags($post['tags']);
            }

            $postObj->setIsPermalinkPage($isPermalinkPage);
            $postObj->setPostId($htmlId);
        }

        return $postObj;
    }

    /**
     * @param string $type
     * @param int $id
     * @return string
     */
    public function parse(string $type = 'page', int $id = 1): string
    {
        $this->parseMetaSettings();

        if ($this->templateChanged) {
            $this->templateChanged = false;
            $this->parseElements();
        }

        $isIndexPage = $type == 'page';
        $isPermalinkPage = $type == 'post';

        if (array_key_exists('posts', $this->settings) && $this->settings['posts']) {
            $configPosts = $this->settings['posts'];
        } else {
            $configPosts = [];
        }

        if (array_key_exists('postsPerPage', $this->settings) && $this->settings['postsPerPage']) {
            $configPostsPerPage = (int)$this->settings['postsPerPage'];
        } else {
            $configPostsPerPage = 15;
        }

        if (array_key_exists('pages', $this->settings) && $this->settings['pages']) {
            $configPages = $this->settings['pages'];
        } else {
            $configPages = [];
        }

        $totalPages = ceil(count($configPosts) / $configPostsPerPage);

        $posts = [];

        if ($isIndexPage) {
            $postIdMin = ($id - 1) * $configPostsPerPage;
            $postIdMax = $postIdMin + $configPostsPerPage;

            for ($postId = $postIdMin; $postId < $postIdMax; $postId++) {
                if (isset($configPosts[$postId])) {
                    $postObj = $this->makePostFromIndex($postId, $isPermalinkPage);
                    if ($postObj) {
                        $posts[] = $postObj;
                    }
                } else {
                    break;
                }
            }
        } elseif ($isPermalinkPage) {
            $postObj = $this->makePostFromIndex($id - 1, $isPermalinkPage);
            if ($postObj) {
                $posts[] = $postObj;

                $variable = new Variable();
                $variable->setName('PostTitle');
                $variable->setValue($postObj->getTitle());

                $this->variables['PostTitle'] = $variable;
            }
        }

        if (!$this->rootElement) {
            return '';
        }

        $this->setElementsValues($this->rootElement, $isIndexPage, $isPermalinkPage,
            $posts, $id, $totalPages, $configPages);

        return $this->renderElements($this->rootElement);
    }
    
    /**
     * @param string $type
     * @param int $id
     * @return string
     */
    public function printHtml(string $type = 'page', int $id = 1): string
    {
        $html = $this->parse($type, $id);

        print $html;
        flush();

        return $html;
    }
}
