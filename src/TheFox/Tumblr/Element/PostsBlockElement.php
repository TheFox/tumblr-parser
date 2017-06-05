<?php

namespace TheFox\Tumblr\Element;

use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Element\Post\PhotoBlockElement;
use TheFox\Tumblr\Element\Post\PhotosetBlockElement;
use TheFox\Tumblr\Element\Post\QuoteBlockElement;
use TheFox\Tumblr\Element\Post\ChatBlockElement;
use TheFox\Tumblr\Element\Post\AnswerBlockElement;
use TheFox\Tumblr\Element\IndexPageBlockElement;
use TheFox\Tumblr\Element\PermalinkPageBlockElement;
use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;
use TheFox\Tumblr\Post\PhotoPost;
use TheFox\Tumblr\Post\PhotosetPost;
use TheFox\Tumblr\Post\QuotePost;
use TheFox\Tumblr\Post\ChatPost;
use TheFox\Tumblr\Post\AnswerPost;

class PostsBlockElement extends BlockElement
{
    public function render()
    {
        $posts = $this->getContent();

        $children = array();
        $html = '';
        if (is_array($posts)) {
            foreach ($posts as $postId => $post) {
                $hasTitle = (bool)$post->getTitle();

                $dateDayOfMonth = '';
                $dateDayOfMonthWithZero = '';
                $dateDayOfWeek = '';
                $dateShortDayOfWeek = '';
                $dateDayOfWeekNumber = '';
                $dateDayOfMonthSuffix = '';
                $dateDayOfYear = '';
                $dateWeekOfYear = '';
                $dateMonth = '';
                $dateShortMonth = '';
                $dateMonthNumber = '';
                $dateMonthNumberWithZero = '';
                $dateYear = '';
                $dateShortYear = '';
                $dateAmPm = '';
                $dateCapitalAmPm = '';
                $date12Hour = '';
                $date24Hour = '';
                $date12HourWithZero = '';
                $date24HourWithZero = '';
                $dateMinutes = '';
                $dateSeconds = '';
                $dateTimestamp = '';

                $postDateTime = $post->getDateTime();
                if ($postDateTime) {
                    $dateDayOfMonth = $postDateTime->format('j');
                    $dateDayOfMonthWithZero = $postDateTime->format('d');
                    $dateDayOfWeek = $postDateTime->format('l');
                    $dateShortDayOfWeek = $postDateTime->format('D');
                    $dateDayOfWeekNumber = $postDateTime->format('N');
                    $dateDayOfMonthSuffix = $postDateTime->format('S');
                    $dateDayOfYear = $postDateTime->format('z');
                    $dateWeekOfYear = $postDateTime->format('W');
                    $dateMonth = $postDateTime->format('F');
                    $dateShortMonth = $postDateTime->format('M');
                    $dateMonthNumber = $postDateTime->format('n');
                    $dateMonthNumberWithZero = $postDateTime->format('m');
                    $dateYear = $postDateTime->format('Y');
                    $dateShortYear = $postDateTime->format('y');
                    $dateAmPm = $postDateTime->format('a');
                    $dateCapitalAmPm = $postDateTime->format('A');
                    $date12Hour = $postDateTime->format('g');
                    $date24Hour = $postDateTime->format('G');
                    $date12HourWithZero = $postDateTime->format('h');
                    $date24HourWithZero = $postDateTime->format('H');
                    $dateMinutes = $postDateTime->format('i');
                    $dateSeconds = $postDateTime->format('s');
                    $dateTimestamp = $postDateTime->format('U');
                }

                $notes = $post->getNotes();
                $notesCount = count($notes);
                $tags = $post->getTags();
                $tagsCount = count($tags);

                // Set all children and subchildren.
                foreach ($this->getChildren(true) as $element) {
                    #$newElement = clone $element;
                    $elementName = strtolower($element->getTemplateName());

                    if ($element instanceof TextBlockElement) {
                        if ($post instanceof TextPost) {
                            $element->setContent($post);
                        }
                    } elseif ($element instanceof LinkBlockElement) {
                        if ($post instanceof LinkPost) {
                            $element->setContent($post);
                        }
                    } elseif ($element instanceof PhotoBlockElement) {
                        if ($post instanceof PhotoPost) {
                            $element->setContent($post);
                        }
                    } elseif ($element instanceof PhotosetBlockElement) {
                        if ($post instanceof PhotosetPost) {
                            $element->setContent($post);
                        }
                    } elseif ($element instanceof QuoteBlockElement) {
                        if ($post instanceof QuotePost) {
                            $element->setContent($post);
                        }
                    } elseif ($element instanceof ChatBlockElement) {
                        if ($post instanceof ChatPost) {
                            $element->setContent($post);
                        }
                    } elseif ($element instanceof AnswerBlockElement) {
                        if ($post instanceof AnswerPost) {
                            $element->setContent($post);
                        }
                    } elseif ($element instanceof VariableElement) {
                        if ($elementName == 'permalink') {
                            $element->setContent($post->getPermalink());
                        } elseif ($elementName == 'dayofmonth') {
                            $element->setContent($dateDayOfMonth);
                        } elseif ($elementName == 'dayofmonthwithzero') {
                            $element->setContent($dateDayOfMonthWithZero);
                        } elseif ($elementName == 'dayofweek') {
                            $element->setContent($dateDayOfWeek);
                        } elseif ($elementName == 'shortdayofweek') {
                            $element->setContent($dateShortDayOfWeek);
                        } elseif ($elementName == 'dayofweeknumber') {
                            $element->setContent($dateDayOfWeekNumber);
                        } elseif ($elementName == 'dayofmonthsuffix') {
                            $element->setContent($dateDayOfMonthSuffix);
                        } elseif ($elementName == 'dayofyear') {
                            $element->setContent($dateDayOfYear);
                        } elseif ($elementName == 'weekofyear') {
                            $element->setContent($dateWeekOfYear);
                        } elseif ($elementName == 'month') {
                            $element->setContent($dateMonth);
                        } elseif ($elementName == 'shortmonth') {
                            $element->setContent($dateShortMonth);
                        } elseif ($elementName == 'monthnumber') {
                            $element->setContent($dateMonthNumber);
                        } elseif ($elementName == 'monthnumberwithzero') {
                            $element->setContent($dateMonthNumberWithZero);
                        } elseif ($elementName == 'year') {
                            $element->setContent($dateYear);
                        } elseif ($elementName == 'shortyear') {
                            $element->setContent($dateShortYear);
                        } elseif ($elementName == 'ampm') {
                            $element->setContent($dateAmPm);
                        } elseif ($elementName == 'capitalampm') {
                            $element->setContent($dateCapitalAmPm);
                        } elseif ($elementName == '12hour') {
                            $element->setContent($date12Hour);
                        } elseif ($elementName == '24hour') {
                            $element->setContent($date24Hour);
                        } elseif ($elementName == '12hourwithzero') {
                            $element->setContent($date12HourWithZero);
                        } elseif ($elementName == '24hourwithzero') {
                            $element->setContent($date24HourWithZero);
                        } elseif ($elementName == 'minutes') {
                            $element->setContent($dateMinutes);
                        } elseif ($elementName == 'seconds') {
                            $element->setContent($dateSeconds);
                        } elseif ($elementName == 'timestamp') {
                            $element->setContent($dateTimestamp);
                        } elseif ($elementName == 'postid') {
                            $element->setContent($post->getPostId());
                        } elseif ($elementName == 'likebutton') {
                            $content = '';
                            $content .= '<div class="like_button" data-post-id="1" id="like_button_1">';
                            $content .= '<iframe id="like_iframe_1" src="http://assets.tumblr.com/assets/html/';
                            $content .= 'like_iframe.html?_v=2#name=thefox21&amp;post_id=1&rk=x9D9S9kC" ';
                            $content .= 'scrolling="no" width="20" height="20" frameborder="0" class="like_toggle" ';
                            $content .= 'allowTransparency="true"></iframe></div>';
                            $element->setContent($content);
                        } elseif ($elementName == 'reblogbutton') {
                            $content = '';
                            $content .= '<a href="" class="reblog_button"style="display: block;width:20px;height:20px;">';
                            $content .= '<svg width="100%" height="100%" viewBox="0 0 21 21" ';
                            $content .= 'xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" ';
                            $content .= 'fill="#ccc"><path d="M5.01092527,5.99908429 L16.0088498,5.99908429 L16.136,9.508 ';
                            $content .= 'L20.836,4.752 L16.136,0.083 L16.1360004,3.01110845 L2.09985349,3.01110845 ';
                            $content .= 'C1.50585349,3.01110845 0.979248041,3.44726568 0.979248041,4.45007306 ';
                            $content .= 'L0.979248041,10.9999998 L3.98376463,8.30993634 L3.98376463,6.89801007 ';
                            $content .= 'C3.98376463,6.20867902 4.71892527,5.99908429 5.01092527,5.99908429 Z">';
                            $content .= '</path><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 ';
                            $content .= '17.022957,14.0490723 16.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 ';
                            $content .= 'L0.5,15.806 L4.92919922,20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 ';
                            $content .= 'C19.5640928,16.9990234 19.9453125,16.4010001 19.9453125,15.8060001 ';
                            $content .= 'L19.9453125,9.5324707 L17.142,12.203"></path></svg></a>';
                            $element->setContent($content);
                        } elseif ($elementName == 'postnotes') {
                            $joinContent = '';
                            $joinContent .= '<div class="clear"></div></li><li class="note reblog tumblelog_thefox21 ';
                            $joinContent .= 'original_post without_commentary"><a rel="nofollow" class="avatar_frame" ';
                            $joinContent .= 'target="_blank" href="http://blog.fox21.at/" title="thefox21"><img ';
                            $joinContent .= 'src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="avatar " ';
                            $joinContent .= 'alt="" /></a><span class="action" data-post-url="http://blog.fox21.at/post/';
                            $joinContent .= '13835148295/hello-world">';

                            $content = '';
                            $content .= '<ol class="notes"><!-- START NOTES --><li class="note reblog tumblelog_thefox21 ';
                            $content .= 'original_post without_commentary"><a rel="nofollow" class="avatar_frame" ';
                            $content .= 'target="_blank" href="http://blog.fox21.at/" title="thefox21">';
                            $content .= '<img src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="avatar " ';
                            $content .= 'alt="" /></a><span class="action" data-post-url="http://blog.fox21.at/';
                            $content .= 'post/13835148295/hello-world">';
                            $content .= join($joinContent, $notes);
                            $content .= '</span><div class="clear"></div></li><!-- END NOTES --></ol>';
                            $element->setContent($content);
                        } elseif ($elementName == 'notecount' && $post->getIsPermalinkPage()) {
                            $element->setContent($notesCount);
                        } elseif ($elementName == 'notecountwithlabel') {
                            $element->setContent($notesCount . ' note' . ($notesCount == 1 ? '' : 's'));
                        }
                    } elseif ($element instanceof DateBlockElement) {
                        $element->setContent(true);
                    } elseif ($element instanceof PostNotesBlockElement) {
                        $element->setContent($notes && $post->getIsPermalinkPage() ? true : false);
                    } elseif ($element instanceof NoteCountBlockElement) {
                        $element->setContent($notes ? true : false);
                    } elseif ($element instanceof HasTagsBlockElement) {
                        $element->setContent($tags ? true : false);
                    } elseif ($element instanceof TagsBlockElement) {
                        $element->setContent($tags);
                    } elseif ($element instanceof TitleBlockElement) {
                        $element->setContent($hasTitle);
                    }
                }

                // Collect level 1 children for rendering.
                foreach ($this->getChildren() as $element) {
                    $rc = new \ReflectionClass(get_class($element));

                    $add = false;
                    if ($element instanceof TextBlockElement) {
                        if ($post instanceof TextPost) {
                            $add = true;
                        }
                    } elseif ($element instanceof LinkBlockElement) {
                        if ($post instanceof LinkPost) {
                            $add = true;
                        }
                    } elseif ($element instanceof PhotoBlockElement) {
                        if ($post instanceof PhotoPost) {
                            $add = true;
                        }
                    } elseif ($element instanceof PhotosetBlockElement) {
                        if ($post instanceof PhotosetPost) {
                            $add = true;
                        }
                    } elseif ($element instanceof QuoteBlockElement) {
                        if ($post instanceof QuotePost) {
                            $add = true;
                        }
                    } elseif ($element instanceof ChatBlockElement) {
                        if ($post instanceof ChatPost) {
                            $add = true;
                        }
                    } elseif ($element instanceof AnswerBlockElement) {
                        if ($post instanceof AnswerPost) {
                            $add = true;
                        }
                    } elseif ($element instanceof VariableElement) {
                        $add = true;
                    } elseif ($element instanceof DateBlockElement) {
                        $add = true;
                    } elseif ($element instanceof PostNotesBlockElement) {
                        $add = true;
                    } elseif ($element instanceof NoteCountBlockElement) {
                        $add = true;
                    } elseif ($element instanceof HasTagsBlockElement) {
                        $add = true;
                    } elseif ($element instanceof TagsBlockElement) {
                        $add = true;
                    } elseif ($element instanceof HtmlElement) {
                        $add = true;
                    } elseif ($element instanceof IndexPageBlockElement) {
                        $add = true;
                    } elseif ($element instanceof PermalinkPageBlockElement) {
                        $add = true;
                    }

                    if ($add) {
                        #$children[] = $newElement;
                        #$children[] = $element;
                        $html .= $element->render();
                    }

                }

            }
        }

        #return $this->renderChildren($children);
        return $html;
    }
}
