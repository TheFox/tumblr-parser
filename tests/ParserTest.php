<?php

use TheFox\Tumblr\Parser;

class ParserTest extends PHPUnit_Framework_TestCase{
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 1
	 */
	public function testSetSettings1(){
		$parser = new Parser();
		$parser->setSettings(array());
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 1
	 */
	public function testSetSettings2(){
		$parser = new Parser();
		$parser->setSettings(array('vars'));
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 2
	 */
	public function testSetSettings3(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array()));
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 2
	 */
	public function testSetSettings4(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array(), 'posts'));
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 3
	 */
	public function testSetSettings5(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array(), 'posts' => array()));
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 4
	 */
	public function testSetSettings6(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array(), 'posts' => array(), 'postsPerPage' => 15));
	}
	
	public function parseVariablePageProvider(){
		$rv = array();
		
		$rv[] = array('', '');
		$rv[] = array('test', 'test');
		$rv[] = array('{Title}>', 'my_title>');
		$rv[] = array('<{Title}', '<my_title');
		$rv[] = array('<{Title}>', '<my_title>');
		$rv[] = array('BEGIN<{Title}>END', 'BEGIN<my_title>END');
		$rv[] = array('BEGIN Title1={Title} Title2={Title} END', 'BEGIN Title1=my_title Title2=my_title END');
		#$rv[] = array('BEGIN Title1=}{Title} END', 'BEGIN Title1=}my_title END');
		$rv[] = array('{', '{');
		$rv[] = array('}', '}');
		$rv[] = array('BEGIN {Title END', 'BEGIN {Title END');
		$rv[] = array('BEGIN Title} END', 'BEGIN Title} END');
		$rv[] = array('BEGIN {block:IfShowTest}OK{/block:IfShowTest} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:IfNotShowTest}NOT_OK{/block:IfNotShowTest} END', 'BEGIN NOT_OK END');
		$rv[] = array('BEGIN {block:IfShowTest}OK{/block:IfShowTest} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:IfNotShowTest}NOT_OK{/block:IfNotShowTest} END', 'BEGIN NOT_OK END');
		
		$rv[] = array('BEGIN {block:IfShowTest2}OK{/block:IfShowTest2} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:IfNotShowTest2}NOT_OK{/block:IfNotShowTest2} END', 'BEGIN NOT_OK END');
		
		$rv[] = array('BEGIN {block:IfAskEnabled}OK{/block:IfAskEnabled} END', 'BEGIN OK END');
		
		$rv[] = array('BEGIN "{lang:Newer posts}" "{lang:Older posts}" END', 'BEGIN "Newer Posts" "Older Posts" END');
		$rv[] = array('BEGIN "{lang:x}" "{lang:y}" END', 'BEGIN "" "" END');
		
		$rv[] = array('BEGIN {block:Posts}{/block:Posts} END', 'BEGIN  END');
		
		$rv[] = array('BEGIN {block:Text}{/block:Text} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Link}{/block:Link} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Photo}{/block:Photo} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Photos}{/block:Photos} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Photoset}{/block:Photoset} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:IndexPage}{/block:IndexPage} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:PermalinkPage}{/block:PermalinkPage} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Title}{/block:Title} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:PostTitle}{/block:PostTitle} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Description}{/block:Description} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:AskEnabled}{/block:AskEnabled} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:HasPages}{/block:HasPages} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Pages}{/block:Pages} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Caption}{/block:Caption} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Quote}{/block:Quote} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Chat}{/block:Chat} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Audio}{/block:Audio} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Video}{/block:Video} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Answer}{/block:Answer} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Source}{/block:Source} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Lines}{/block:Lines} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Label}{/block:Label} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Date}{/block:Date} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:AudioEmbed}{/block:AudioEmbed} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:NoteCount}{/block:NoteCount} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:HasTags}{/block:HasTags} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:PostNotes}{/block:PostNotes} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Pagination}{/block:Pagination} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:PreviousPage}{/block:PreviousPage} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:NextPage}{/block:NextPage} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:Tags}{/block:Tags} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:LinkURL}{/block:LinkURL} END', 'BEGIN  END');
		
		$rv[] = array('BEGIN {text:Text1} END', 'BEGIN  END');
		$rv[] = array('BEGIN {text:Text2} END', 'BEGIN my_text2 END');
		
		$rv[] = array('BEGIN {MyBlock1} END', 'BEGIN {MyBlock1} END');
		$rv[] = array('BEGIN {MyBlock2} END', 'BEGIN {MyBlock2} END');
		
		$rv[] = array('BEGIN {lang:Page CurrentPage of TotalPages} END', 'BEGIN Page 2 of 6 END');
		$rv[] = array('BEGIN {PreviousPage} END', 'BEGIN ?type=page&id=1 END');
		$rv[] = array('BEGIN {NextPage} END', 'BEGIN ?type=page&id=3 END');
		
		$rv[] = array('BEGIN {block:Description}My Descr1:{/block:Description} END', 'BEGIN My Descr1: END');
		$rv[] = array('BEGIN {block:Description}My Descr2: {MetaDescription}{/block:Description} END',
			'BEGIN My Descr2: my_descr1 END');
		
		#$rv[] = array('test', 'test');
		
		return $rv;
	}
	
	/**
	 * @dataProvider parseVariablePageProvider
	 */
	public function testParseVariablePage($tpl, $expected){
		$parser = new Parser();
		$parser->setSettings(array(
			'vars' => array(
				'Title' => 'my_title',
				'MetaDescription' => 'my_descr1',
				'AskEnabled' => 1,
				'if:Show Test' => 0,
				
				'lang:Newer posts' => 'Newer Posts',
				'lang:Older posts' => 'Older Posts',
				
				'text:Text2' => 'my_text2',
				
				'MyBlock2' => 'my_block2',
			),
			'posts' => array(
				array('type' => 'text', 'permalink' => '?type=post&index=1', 'date' => '1987-02-21 09:58:00',
					'notes' => array('text_1', 'text2'), 'tags' => array('tag1', 'tag_2'), 'title' => 'title_test1',
					'body' => 'test1.body', 'description' => 'my_descr2'),
				array('type' => 'text', 'date' => '1987-02-21 09:58:00', 'body' => 'test2.body'),
				array('type' => 'text', 'date' => '1987-02-21 09:58:00', 'title' => 'title_test3'),
				array('type' => 'link', 'date' => '1987-02-21 09:58:00', 'url' => 'http://fox21.at',
					'name' => 'link_name1', 'target' => 'target="_blank"', 'description' => 'this is my description'),
				array('type' => 'link', 'date' => '1987-02-21 09:58:00', 'url' => 'http://www.fox21.at',
					'name' => 'link_name2'),
				array('type' => 'photo', 'date' => '1987-02-21 09:58:00',
					'url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg',
					'link' => 'https://en.wikipedia.org/wiki/Halloumi', 'alt' => 'my alt text',
					'caption' => 'my caption text'),
				array('type' => 'photo', 'date' => '1987-02-21 09:58:00',
					'url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg',
					'alt' => 'my alt text'),
				array('type' => 'photoset', 'date' => '1987-02-21 09:58:00', 'caption' => 'my super fancy caption',
					'photos' => array(
						array('url' => 'https://farm3.staticflickr.com/2856/9816324626_63726c6fdd.jpg',
							'link' => 'https://en.wikipedia.org/wiki/Halloumi', 'alt' => 'my alt text3',
							'caption' => 'my caption text3'),
						array('url' => 'https://farm4.staticflickr.com/3057/2494697235_7617067bca.jpg',
							'alt' => 'my alt text4'),
					)),
				array('type' => 'quote', 'date' => '1987-02-22 10:00:00', 'notes' => array('text_1', 'text2'),
					'tags' => array('tag1', 'tag_2'),
					'quote' => 'I\'m gonna taste like heaven.', 'source' => 'The Sausage', 'length' => 'short'),
				array('type' => 'chat', 'date' => '1987-02-23 10:00:00', 'notes' => array('text_1', 'text2'),
					'tags' => array('tag1', 'tag_2'), 'title' => 'my chat title',
					'chats' => array(
						array('label' => 'Johnny Cash',
							'line' => 'Dear God, give us Freddie Mercury back and we will send you Justin Bieber.'),
						array('label' => 'Freddie Mercury', 'line' => 'I will rock you.'),
						array('label' => 'God', 'line' => 'Mkay.'),
						array('label' => 'Justin Bieber', 'line' => 'Aw maaan. :('),
						array('label' => 'God', 'line' => 'Done.'),
					)
				),
				array('type' => 'answer', 'date' => '1987-03-01 09:08:07', 'notes' => array('text_1', 'text2'),
					'tags' => array('tag1', 'tag_2'), 'asker' => 'A Asker',
					'question' => 'The question is what is the question?',
					'answer' => 'The answer might be similar.'),
			),
			'postsPerPage' => 2,
			'pages' => array(
				array('url' => 'http://fox21.at', 'label' => 'FOX21.at'),
				array('url' => 'http://tools.fox21.at', 'label' => 'Tools'),
				array('url' => 'http://test.fox21.at', 'label' => 'Test'),
			),
		));
		
		$parser->setTemplate($tpl);
		$this->assertEquals($expected, $parser->parse('page', 2));
	}
	
	public function parseVariablePostProvider(){
		$rv = array();
		
		$rv[] = array('BEGIN {block:Description}My Descr1: {/block:Description} END', 'BEGIN  END');
		$rv[] = array('BEGIN {block:IfAskEnabled}OK{/block:IfAskEnabled} END', 'BEGIN  END');
		
		return $rv;
	}
	
	/**
	 * @dataProvider parseVariablePostProvider
	 */
	public function testParseVariablePost($tpl, $expected){
		$parser = new Parser();
		$parser->setSettings(array(
			'vars' => array(
				'Title' => 'my_title',
			),
			'posts' => array(
				array('type' => 'text', 'permalink' => '?type=post&index=1', 'date' => '1987-02-21 09:58:00',
					'notes' => array('text_1', 'text2'), 'tags' => array('tag1', 'tag_2'),
					'title' => 'title_test1', 'body' => 'test1.body', 'description' => 'my_descr2'),
			),
			'postsPerPage' => 1,
			'pages' => array(),
		));
		
		$parser->setTemplate($tpl);
		$this->assertEquals($expected, $parser->parse('post', 1));
	}
	
	public function parseVariableProvider2(){
		$rv = array();
		
		$tmp = '<meta name="if:Show Test" content="0" />BEGIN {block:IfShowTest}OK{/block:IfShowTest} END';
		$rv[] = array($tmp, '<meta name="if:Show Test" content="0" />BEGIN  END');
		
		$tmp = '<meta name="if:Show Test" content="0" />BEGIN {block:IfNotShowTest}NOT_OK{/block:IfNotShowTest} END';
		$rv[] = array($tmp, '<meta name="if:Show Test" content="0" />BEGIN NOT_OK END');
		
		$tmp = '<meta name="if:Show Test" content="0" />BEGIN {block:IfShowTest}OK{/block:IfShowTest} END';
		$rv[] = array($tmp, '<meta name="if:Show Test" content="0" />BEGIN  END');
		
		$tmp = '<meta name="if:Show Test" content="0" />BEGIN {block:IfNotShowTest}NOT_OK{/block:IfNotShowTest} END';
		$rv[] = array($tmp, '<meta name="if:Show Test" content="0" />BEGIN NOT_OK END');
		
		$tmp = '<meta name="if:Show Test" content="1" />BEGIN {block:IfShowTest}OK{/block:IfShowTest} END';
		$rv[] = array($tmp, '<meta name="if:Show Test" content="1" />BEGIN OK END');
		
		$tmp = '<meta name="if:Show Test" content="1" />BEGIN {block:IfNotShowTest}OK{/block:IfNotShowTest} END';
		$rv[] = array($tmp, '<meta name="if:Show Test" content="1" />BEGIN  END');
		
		return $rv;
	}
	
	/**
	 * @dataProvider parseVariableProvider2
	 */
	public function testParseVariable2($tpl, $expected){
		$parser = new Parser();
		$parser->setSettings(array(
			'vars' => array(
				'Title' => 'my_title',
			),
			'posts' => array(),
			'postsPerPage' => 15,
			'pages' => array()
		));
		
		$parser->setTemplate($tpl);
		$this->assertEquals($expected, $parser->parse());
	}
	
	public function parseVariableProvider3(){
		$rv = array();
		
		$rv[] = array('BEGIN {block:IfShowTest}OK{/block:IfShowTest} END', 'BEGIN OK END');
		$rv[] = array('BEGIN {block:IfNotShowTest}NOT_OK{/block:IfNotShowTest} END', 'BEGIN  END');
		
		$rv[] = array('BEGIN {block:AskEnabled}OK{/block:AskEnabled} END', 'BEGIN  END');
		
		$tmp = '<meta name="if:Show Test" content="0" />BEGIN {block:IfShowTest}OK{/block:IfShowTest} END';
		$rv[] = array($tmp, '<meta name="if:Show Test" content="0" />BEGIN OK END');
		
		$tmp = '<meta name="if:Show Test" content="0" />BEGIN {block:IfNotShowTest}NOT_OK{/block:IfNotShowTest} END';
		$rv[] = array($tmp, '<meta name="if:Show Test" content="0" />BEGIN  END');
		
		return $rv;
	}
	
	/**
	 * @dataProvider parseVariableProvider3
	 */
	public function testParseVariable3($tpl, $expected){
		$parser = new Parser();
		$parser->setSettings(array(
			'vars' => array(
				'Title' => 'my_title',
				'if:Show Test' => 1,
			),
			'posts' => array(),
			'postsPerPage' => 15,
			'pages' => array()
		));
		
		$parser->setTemplate($tpl);
		$this->assertEquals($expected, $parser->parse());
	}
	
	public function testParseVariable99(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array('Title' => 'my_title'), 'posts' => array(), 'postsPerPage' => 15,
			'pages' => array()));
		
		$this->assertTrue(true);
		
		/*$parser->setTemplate('{');
		$this->assertEquals('{', $parser->parse());
		
		$parser->setTemplate('}');
		$this->assertEquals('}', $parser->parse());
		
		$parser->setTemplate('BEGIN {Title END');
		$this->assertEquals('BEGIN {Title END', $parser->parse());
		
		$parser->setTemplate('BEGIN Title} END');
		$this->assertEquals('BEGIN Title} END', $parser->parse());
		*/
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 1
	 */
	public function testParseVariableRuntimeException1(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array(), 'posts' => array(), 'postsPerPage' => 15,
			'pages' => array()));
		
		$parser->setTemplate('BEGIN {block:IfText} END');
		$this->assertEquals('BEGIN my_title END', $parser->parse());
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 3
	 */
	public function testParseVariableRuntimeException2(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array(), 'posts' => array(), 'postsPerPage' => 15,
			'pages' => array()));
		
		$parser->setTemplate('BEGIN {block:Unknown}x{/block:Unknown} END');
		$this->assertEquals('BEGIN my_title END', $parser->parse());
	}
	
}
