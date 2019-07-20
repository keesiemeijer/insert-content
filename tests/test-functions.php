<?php
namespace keesiemeijer\Insert_Content;

class Insert_Content_Test extends \PHPUnit\Framework\TestCase {

	/**
	 * @dataProvider addDataProvider
	 */
	public function test_insert_content($content, $expected, $insert_content, $args, $message) {
		$insert = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ), $message );
	}

	public function addDataProvider() {
		return array(
			array(
				'<p>1</p><p>2</p>', // content
				'<p>1</p><p>inserted paragraph</p><p>2</p>', // expected
				'inserted paragraph', // insert content
				array(), // arguments
				'Insert in middle without arguments. (default arguments)', // message
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p>inserted paragraph</p><p>2</p>',
				array('inserted paragraph', 'second paragraph'),
				array(),
				'Insert in middle without arguments. (default arguments) (array content)',
			),
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array(),
				'Insert after content with only one paragraph. (default arguments)',
			),
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array(),
				'Insert after content with only one paragraph. (default arguments) (array content)',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>',
				'inserted paragraph',
				array( 'parent_element_id' => 'parent' ),
				'Insert in parent element after last (and only) paragraph.',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'parent_element_id' => 'parent' ),
				'Insert in parent element after last (and only) paragraph. (array content)',
			),
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2 ),
				'Insert after second paragraph with insert_after_p',
			),
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2 ),
				'Insert after second paragraph with insert_after_p. (array content)',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>3</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p><p>3</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
				'Insert in parent element, after second paragraph with insert_after_p',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>3</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p><p>3</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
				'Insert in parent element, after second paragraph with insert_after_p (array content)',
			),
			array(
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>3</p>',
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>3</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2 ),
				'Insert after second paragraph with nested paragraph in blockquote',
			),
			array(
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>3</p>',
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>3</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2 ),
				'Insert after second paragraph with nested paragraph in blockquote (array content)',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>3</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>3</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
				'Insert in parent element, after second paragraph with nested paragraph in blockquote',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>3</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>3</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
				'Insert in parent element after second paragraph with nested paragraph in blockquote. (array content)',
			),
			array(
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p>',
				'<p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'top_level_p_only' => false ),
				'Insert after second paragraph with with nested paragraph in blockquote and top_level_p_only false',
			),
			array(
				'<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p>',
				'<p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'top_level_p_only' => false ),
				'Insert after second paragraph with with nested paragraph in blockquote and top_level_p_only false. (array content)',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent',  ),
				'Insert in parent element, after second paragraph with with nested paragraph in blockquote and top_level_p_only false.',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent',  ),
				'Insert in parent element, after second paragraph with with nested paragraph in blockquote and top_level_p_only false. (array content)',
			),
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 6 ),
				'Insert after last paragraph if not enough paragraphs are found',
			),
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 6 ),
				'Insert after last paragraph if not enough paragraphs are found. (array_content)',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 6, 'parent_element_id' => 'parent' ),
				'Insert in parent element, after last paragraph if not enough paragraphs are found.',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 6, 'parent_element_id' => 'parent' ),
				'Insert in parent element, after last paragraph if not enough paragraphs are found. (array_content)',
			),
			array(
				'<p>1</p>',
				'<p>1</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 6, 'insert_if_no_p' => false ),
				"Don't insert after last paragraph if not enough paragraphs are found and insert_if_no_p is false.",
			),
			array(
				'<p>1</p>',
				'<p>1</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 6, 'insert_if_no_p' => false ),
				"Don't insert after last paragraph if not enough paragraphs are found and insert_if_no_p is false. (array_content)",
			),
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 6, 'insert_if_no_p' => false, 'parent_element_id' => 'parent' ),
				"Don't insert in parent element, after last paragraph if not enough paragraphs are found and insert_if_no_p is false.",
			),
			array(
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p></div><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 6, 'insert_if_no_p' => false, 'parent_element_id' => 'parent' ),
				"Don't insert in parent element, after last paragraph if not enough paragraphs are found and insert_if_no_p is false. (array_content)",
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p>',
				'<strong>inserted</strong> paragraph',
				array( 'insert_after_p' => 1 ),
				'Insert content with HTML',
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p>',
				array('<strong>inserted</strong> paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1 ),
				'Insert content with HTML. (array content)',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p></div><p>text</p>',
				'<strong>inserted</strong> paragraph',
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
				'Insert in parent element content with HTML.',
			),

			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p></div><p>text</p>',
				array('<strong>inserted</strong> paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
				'Insert in parent element, content with HTML. (array content)',
			),
			array(
				'<div>content</div>',
				'<div>content</div><p>inserted paragraph</p>',
				'inserted paragraph',
				array(),
				'Insert after content if no paragraphs are found. (default arguments)',
			),
			array(
				'<div>content</div>',
				'<div>content</div><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array(),
				'Insert after content if no paragraphs are found. (default arguments) (array content)',
			),
			array(
				'<p>1</p><div id="parent">content</div><p>2</p>',
				'<p>1</p><div id="parent">content</div><p>inserted paragraph</p><p>2</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
				'Insert after parent element if no paragraphs are found.',
			),
			array(
				'<p>1</p><div id="parent">content</div><p>2</p>',
				'<p>1</p><div id="parent">content</div><p>inserted paragraph</p><p>2</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
				'Insert after parent element if no paragraphs are found. (array content)',
			),
			array(
				'content',
				'<p>content</p><p>inserted paragraph</p>', // paragraph added
				'inserted paragraph',
				array(),
				"Paragraph is added if it's only a text node",
			),
			array(
				'content',
				'<p>content</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array(),
				"Paragraph is added if it's only a text node. (array content)",
			),
			array(
				'<div>content<p>1</p>',
				'<div>content<p>1</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2 ),
				'Insert paragraph is added with malformed HTML in content',
			),
			array(
				'<div>content<p>1</p>',
				'<div>content<p>1</p><p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2 ),
				'Insert paragraph is added with malformed HTML in content (array content)',
			),
			array(
				'<div id="parent">content<p>1</p>',
				'<div id="parent">content<p>1</p><p>inserted paragraph</p></div>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
				'Insert paragraph and closing div is added with malformed HTML in parent content',
			),
			array(
				'<div id="parent">content<p>1</p>',
				'<div id="parent">content<p>1</p><p>inserted paragraph</p></div>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' ),
				'Insert paragraph and closing div tag is added with malformed HTML in parent content (array content)',
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p><strong>inserted paragraph</strong></p><p>2</p>',
				'<strong>inserted paragraph',
				array( 'insert_after_p' => 1 ),
				'Closing strong tag is added to inserted content',
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p><strong>inserted paragraph</strong></p><p>2</p>',
				array('<strong>inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1 ),
				'Closing strong tag is added to inserted content. (array content)',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p><strong>inserted paragraph</strong></p><p>2</p></div><p>text</p>',
				'<strong>inserted paragraph',
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
				'Closing strong tag is added to inserted content in parent element.',
			),
			array(
				'<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>',
				'<p>text</p><div id="parent"><p>1</p><p><strong>inserted paragraph</strong></p><p>2</p></div><p>text</p>',
				array('<strong>inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' ),
				'Closing strong tag is added to inserted content in parent element. (array content)',
			),
			array(
				'<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>2</p>',
				'<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>inserted paragraph</p><p>2</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 1 ),
				'Checking UTF8 content is handled correctly.',
			),
			array(
				'<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>2</p>',
				'<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>inserted paragraph</p><p>2</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 1 ),
				'Checking UTF8 content is handled correctly. (array content)',
			),
			array(
				'<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div>',
				'<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div><p>äöüß</p>',
				'äöüß',
				array(),
				'Checking UTF8 in insert content is handled correctly. ',
			),
			array(
				'<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div>',
				'<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div><p>äöüß</p>',
				array('äöüß', 'second paragraph'),
				array(),
				'Checking UTF8 in insert content is handled correctly. (array content)',
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><div>inserted div</div><p>2</p>',
				'inserted div',
				array( 'insert_element' => 'div' ),
				'Insert div with the insert_element argument',
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><div>inserted div</div><p>2</p>',
				array('inserted div', 'second div'),
				array( 'insert_element' => 'div' ),
				'Insert div with the insert_element argument. (array content)',
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p>inserted div</p><p>2</p>',
				'inserted div',
				array( 'insert_element' => '' ),
				'Insert paragraph if insert_element argument is empty.',
			),
			array(
				'<p>1</p><p>2</p>',
				'<p>1</p><p>inserted div</p><p>2</p>',
				array('inserted div', 'second div'),
				array( 'insert_element' => '' ),
				'Insert paragraph if insert_element argument is empty. (array content)',
			),
			array(
				'',
				'<p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'top_level_p_only' => false ),
				'Insert paragraph if content is empty and top_level_p_only is false',
			),
			array(
				'',
				'<p>inserted paragraph</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'top_level_p_only' => false ),
				'Insert paragraph if content is empty and top_level_p_only is false (array content)',
			),
			array(
				'<div id="parent"></div><p>text</p>',
				'<div id="parent"></div><p>inserted paragraph</p><p>text</p>',
				'inserted paragraph',
				array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent' ),
				'Insert after parent element if top_level_p_only is false and no paragraphs are found',
			),
			array(
				'<div id="parent"></div><p>text</p>',
				'<div id="parent"></div><p>inserted paragraph</p><p>text</p>',
				array('inserted paragraph', 'second paragraph'),
				array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent' ),
				'Insert after parent element if top_level_p_only is false and no paragraphs are found. (array content)',
			),
			array(
				'<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p><p>4</p><p>inserted paragraph</p><p>5</p>',
				'inserted paragraph',
				array('insert_every_p' => 2 ),
				'Insert every 2 paragraphs',
			),
			array(
				'<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p><p>4</p><p>inserted paragraph</p><p>5</p>',
				array('inserted paragraph'),
				array('insert_every_p' => 2 ),
				'Insert every 2 paragraphs with content array with one string. (array content)',
			),
			array(
				'<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><div>inserted div</div><p>3</p><p>4</p><div>inserted div</div><p>5</p>',
				'inserted div',
				array( 	'insert_every_p' => 2, 'insert_element' => 'div' ),
				'Insert every 2 paragraphs with insert element set to div.',
			),
			array(
				'<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><div>inserted div</div><p>3</p><p>4</p><div>second div</div><p>5</p>',
				array('inserted div', 'second div'),
				array( 	'insert_every_p' => 2, 'insert_element' => 'div' ),
				'Insert every 2 paragraphs with insert element set to div and array content of two strings. (array content)',
			),
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>inserted paragraph</p><p>2</p><p>inserted paragraph</p><p>3</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 'insert_every_p' => 1 ),
				'Insert after every paragraph',
			),
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>inserted paragraph</p><p>2</p><p>inserted paragraph</p><p>3</p><p>inserted paragraph</p>',
				array('inserted paragraph'),
				array( 'insert_every_p' => 1 ),
				'Insert after every paragraph. (array content)',
			),
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>',
				'inserted paragraph',
				array( 	'insert_every_p' => 2 ),
				'Insert once with insert_every_p and not enough paragraphs are found',
			),
			array(
				'<p>1</p><p>2</p><p>3</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>',
				array('inserted paragraph'),
				array( 	'insert_every_p' => 2 ),
				'Insert once with insert_every_p and not enough paragraphs are found. (array content)',
			),
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 	'insert_every_p' => 2 ),
				'Insert after last paragraph with insert_every_p and not enough paragraphs are found',
			),
			array(
				'<p>1</p>',
				'<p>1</p><p>inserted paragraph</p>',
				array('inserted paragraph'),
				array( 	'insert_every_p' => 2 ),
				'Insert after last paragraph with insert_every_p and not enough paragraphs are found. (array content)',
			),
			array(
				'<div>1</div>',
				'<div>1</div><p>inserted paragraph</p>',
				'inserted paragraph',
				array( 	'insert_every_p' => 2 ),
				'Insert after content with insert_every_p and no paragraphs are found.',
			),
			array(
				'<div>1</div>',
				'<div>1</div><p>inserted 1</p>',
				array('inserted 1', 'inserted 2'),
				array('insert_every_p' => 2 ),
				'Insert after content with insert_every_p and no paragraphs are found. (array content)',
			),
			array(
				'<div>1</div>',
				'<div>1</div>',
				'inserted paragraph',
				array('insert_every_p' => 2, 'insert_if_no_p' => false ),
				"Don't insert with insert_every_p and insert_if_no_p is false and no paragraphs are found. (array content)",
			),
			array(
				'<p>1</p><p>2</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><p>inserted paragraph</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>inserted paragraph</p><p>5</p>',
				array('inserted paragraph'),
				array('insert_every_p' => 2 ),
				'Insert after second paragraph with insert_every_p and nested paragraph in blockquote and top_level_p_only true.',

			),
			array(
				'<p>1</p><p>2</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>5</p>',
				'<p>1</p><p>2</p><p>inserted 1</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>inserted 2</p><p>5</p>',
				array('inserted 1', 'inserted 2'),
				array('insert_every_p' => 2 ),
				'Insert after second paragraph with insert_every_p and nested paragraph in blockquote and top_level_p_only true. (array content)',
			),
			array(
				'<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>3</p><p>4</p></div><p>3</p>',
				'<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>inserted paragraph</p><p>3</p><p>4</p><p>inserted paragraph</p></div><p>3</p>',
				'inserted paragraph',
				array( 	'insert_every_p' => 2, 'parent_element_id' => 'my-id' ),
				'insert inside parent element, after every 2 paragraphs',
			),
			array(
				'<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>3</p><p>4</p></div><p>3</p>',
				'<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>inserted 1</p><p>3</p><p>4</p><p>inserted 2</p></div><p>3</p>',
				array('inserted 1', 'inserted 2'),
				array( 	'insert_every_p' => 2, 'parent_element_id' => 'my-id' ),
				'insert inside parent element, after every 2 paragraphs. (array content)',
			),			
		);
	}

	function strip_ws( $txt ) {
		$lines = explode( "\n", $txt );
		$result = array();
		foreach ( $lines as $line ) {
			if ( trim( $line ) ) {
				$result[] = trim( $line );
			}
		}

		return trim( join( '', $result ) );
	}
}
