<?php
namespace keesiemeijer\Insert_Content;

class Insert_Content_Test extends \PHPUnit\Framework\TestCase {

	public function setUp() { }
	public function tearDown() { }

	/**
	 * @dataProvider addDataProvider
	 */
	public function test_insert_content($content, $expected, $insert_content, $args) {
		$insert = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function addDataProvider() {
		return array(
			// 1
			array(
				'<p>1</p><p>2</p>', // content
				'<p>1</p><p>inserted paragraph</p><p>2</p>', // expected
				'inserted paragraph', // insert content
				array(), // arguments
			),
			// 2
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p>inserted paragraph</p><p>2</p>',
				array('inserted paragraph', 'second paragraph'),
				array(),
			),
			// 3
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array(),
			),
			// 4
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array(),
			),
			// 5
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>',
				'inserted paragraph',
				array( 'parent_element_id' => 'parent' ),
			),
			// 6
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'parent_element_id' => 'parent' ),
			),
			// 7
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2 ),
			),
			// 8
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2 ),
			),
			// 9 
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>3</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p><p>3</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
			),
			// 10
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>3</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p><p>3</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
			),
			// 11
			array(
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>3</p>',
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>3</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2 ),
			),
			// 12
			array(
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>3</p>',
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>3</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2 ),
			),
			// 13
			array(
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>3</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>3</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
			),
			// 14
			array(
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>3</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>3</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
			),
			// 15
			array(
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p>',
				'<p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'top_level_p_only' => false ),
			),
			// 16
			array(
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p>',
				'<p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'top_level_p_only' => false ),
			),
			// 17
			array(
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent',  ),
			),
			// 18
			array(
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent',  ),
			),
			// 19
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2 ),
			),
			// 20
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2 ),
			),
			// 21
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
			),
			// 22
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
			),
			// 23
			array(
				'<p>1</p>',
				'<p>1</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'insert_if_no_p' => false ),
			),
			// 24
			array(
				'<p>1</p>',
				'<p>1</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'insert_if_no_p' => false ),
			),
			// 25
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'insert_if_no_p' => false, 'parent_element_id' => 'parent' ),
			),
			// 26
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'insert_if_no_p' => false, 'parent_element_id' => 'parent' ),
			),
			// 27
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 6 ),
			),
			// 28
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 6 ),
			),
			// 29
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 6, 'parent_element_id' => 'parent' ),
			),
			// 30
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 6, 'parent_element_id' => 'parent' ),
			),
			// 31
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p>',
				'<strong>inserted</strong> paragraph',
				array( 'insert_after_p' => 1 ),
			),
			// 32
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p>',
				array('<strong>inserted</strong> paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1 ),
			),
			// 33
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p></div><p>text</p>',
				'<strong>inserted</strong> paragraph',
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
			),
			// 34
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p></div><p>text</p>',
				array('<strong>inserted</strong> paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
			),
			// 35
			array(
				'<div>content</div>',
				'<div>content</div><p>inserted paragraph</p>',
				'inserted paragraph',
				array(),
			),
			// 36
			array(
				'<div>content</div>',
				'<div>content</div><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array(),
			),
			// 37
			array(
				'<p>1</p><div id="parent">content</div><p>2</p>',
				'<p>1</p><div id="parent">content</div><p>inserted paragraph</p><p>2</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
			),
			// 38
			array(
				'<p>1</p><div id="parent">content</div><p>2</p>',
				'<p>1</p><div id="parent">content</div><p>inserted paragraph</p><p>2</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
			),
			// 39
			array(
				'content',
				'<p>content</p><p>inserted paragraph</p>', // paragraph added
				'inserted paragraph',
				array(),
			),
			// 40
			array(
				'content',
				'<p>content</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array(),
			),
			// 41
			array(
				'<div>content<p>1</p>',
				'<div>content<p>1</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2 ),
			),
			// 42
			array(
				'<div>content<p>1</p>',
				'<div>content<p>1</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2 ),
			),
			// 43
			array(
				'<div id="parent">content<p>1</p>',
				'<div id="parent">content<p>1</p><p>inserted paragraph</p></div>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
			),
			// 44
			array(
				'<div id="parent">content<p>1</p>',
				'<div id="parent">content<p>1</p><p>inserted paragraph</p></div>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
			),
			// 45
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p><strong>inserted paragraph</strong></p><p>2</p>',
				'<strong>inserted paragraph',
				array( 'insert_after_p' => 1 ),
			),
			// 46
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p><strong>inserted paragraph</strong></p><p>2</p>',
				array('<strong>inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1 ),
			),
			// 47
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p><strong>inserted paragraph</strong></p><p>2</p></div><p>text</p>',
				'<strong>inserted paragraph',
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
			),
			// 48
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p><strong>inserted paragraph</strong></p><p>2</p></div><p>text</p>',
				array('<strong>inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
			),
			// 49
			array(
				'<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>2</p>',
				'<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>inserted paragraph</p><p>2</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 1 ),
			),
			// 50
			array(
				'<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>2</p>',
				'<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>inserted paragraph</p><p>2</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1 ),
			),
			// 51
			array(
				'<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div>',
				'<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div><p>äöüß</p>',
				'äöüß',
				array(),
			),
			// 52
			array(
				'<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div>',
				'<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div><p>äöüß</p>',
				array('äöüß', 'second paragraph'),
				array(),
			),
			// 53
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><div>inserted div</div><p>2</p>',
				'inserted div',
				array( 'insert_element' => 'div' ),
			),
			// 54
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><div>inserted div</div><p>2</p>',
				array('inserted div', 'second div'),
				array( 'insert_element' => 'div' ),
			),
			// 55
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p>inserted div</p><p>2</p>',
				'inserted div',
				array( 'insert_element' => '' ),
			),
			// 56
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p>inserted div</p><p>2</p>',
				array('inserted div', 'second div'),
				array( 'insert_element' => '' ),
			),
			// 57
			array(
				'',
				'<p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'top_level_p_only' => false ),
			),
			// 58
			array(
				'',
				'<p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'top_level_p_only' => false ),
			),
			// 59
			array(
				'<div id="parent"></div><p>text</p>',
				'<div id="parent"></div><p>inserted paragraph</p><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent' ),
			),
			// 60
			array(
				'<div id="parent"></div><p>text</p>',
				'<div id="parent"></div><p>inserted paragraph</p><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent' ),
			),
			// 61
			array(
				'<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p><p>4</p><p>inserted paragraph</p><p>5</p>',
				'inserted paragraph',
				array('insert_every_p' => 2 ),
			),
			// 62
			array(
				'<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p><p>4</p><p>inserted paragraph</p><p>5</p>',
				array('inserted paragraph'),
				array('insert_every_p' => 2 ),
			),
			// 63
			array(
				'<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><div>inserted div</div><p>3</p><p>4</p><div>inserted div</div><p>5</p>',
				'inserted div',
				array( 	'insert_every_p' => 2, 'insert_element' => 'div' ),
			),
			// 64
			array(
				'<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><div>inserted div</div><p>3</p><p>4</p><div>second div</div><p>5</p>',
				array('inserted div', 'second div'),
				array( 	'insert_every_p' => 2, 'insert_element' => 'div' ),
			),
			// 65
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>inserted paragraph</p><p>2</p><p>inserted paragraph</p><p>3</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_every_p' => 1 ),
			),
			// 66
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>inserted paragraph</p><p>2</p><p>inserted paragraph</p><p>3</p><p>inserted paragraph</p>',
				array('inserted paragraph'),
				array( 'insert_every_p' => 1 ),
			),
			// 67
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>',
				'inserted paragraph',
				array( 	'insert_every_p' => 2 ),
			),
			// 68
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>',
				array('inserted paragraph'),
				array( 	'insert_every_p' => 2 ),
			),
			// 69
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 	'insert_every_p' => 2 ),
			),
			// 70
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				array('inserted paragraph'),
				array( 	'insert_every_p' => 2 ),
			),
			// 71
			array(
				'<div>1</div>',
				'<div>1</div><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 	'insert_every_p' => 2 ),
			),
			// 72
			array(
				'<div>1</div>',
				'<div>1</div><p>inserted paragraph</p>',
				array('inserted paragraph'),
				array( 	'insert_every_p' => 2 ),
			),
			// 73
			array(
				'<div>1</div>',
				'<div>1</div><p>inserted 1</p>',
				array('inserted 1', 'inserted 2'),
				array('insert_every_p' => 2 ),
			),
			// 74
			array(
				'<div>1</div>',
				'<div>1</div>',
				'inserted paragraph',
				array('insert_every_p' => 2, 'insert_if_no_p' => false ),
			),
			// 75
			array(
				'<p>1</p><p>2</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>inserted paragraph</p><p>5</p>',
				array('inserted paragraph'),
				array('insert_every_p' => 2 ),
			),
			// 76
			array(
				'<p>1</p><p>2</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><p>inserted 1</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>inserted 2</p><p>5</p>',
				array('inserted 1', 'inserted 2'),
				array('insert_every_p' => 2 ),
			),
			// 77
			array(
				'<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>3</p><p>4</p></div><p>3</p>',
				'<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>inserted paragraph</p><p>3</p><p>4</p><p>inserted paragraph</p></div><p>3</p>',
				'inserted paragraph',
				array( 	'insert_every_p' => 2, 'parent_element_id' => 'my-id' ),
			),
			// 78
			array(
				'<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>3</p><p>4</p></div><p>3</p>',
				'<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>inserted 1</p><p>3</p><p>4</p><p>inserted 2</p></div><p>3</p>',
				array('inserted 1', 'inserted 2'),
				array( 	'insert_every_p' => 2, 'parent_element_id' => 'my-id' ),
			),			
		);
	}

	function strip_ws( $txt ) {
		$lines = explode( '\n', $txt );
		$result = array();
		foreach ( $lines as $line ) {
			if ( trim( $line ) ) {
				$result[] = trim( $line );
			}
		}

		return trim( join( '', $result ) );
	}
}
