<?php
namespace keesiemeijer\Insert_Content;

class Insert_Content_Test extends \PHPUnit_Framework_TestCase {

	public function setUp() { }
	public function tearDown() { }

	public function test_insert_middle() {

		$content  = "<p>first paragraph</p><p>second paragraph</p>";
		$expected = "<p>first paragraph</p><p>inserted paragraph</p><p>second paragraph</p>";

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_middle_content_1p() {

		$content  = "<p>first paragraph</p>";
		$expected = "<p>first paragraph</p><p>inserted paragraph</p>";

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_middle_content_1p() {

		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p>inserted paragraph</p></div><p>paragraph</p>';

		$args = array( 'parent_element_id' => 'parent' );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2() {

		$content  = "<p>first paragraph</p><p>second paragraph</p><p>third paragraph</p>";
		$expected = "<p>first paragraph</p><p>second paragraph</p><p>inserted paragraph</p><p>third paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2() {

		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p>second paragraph</p><p>third paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p>second paragraph</p><p>inserted paragraph</p><p>third paragraph</p></div><p>paragraph</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_with_child_p() {

		$content  = "<p>first paragraph</p><blockquote><p>blockquote</p></blockquote><p>second paragraph</p><p>third paragraph</p>";
		$expected = "<p>first paragraph</p><blockquote><p>blockquote</p></blockquote><p>second paragraph</p><p>inserted paragraph</p><p>third paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_with_child_p() {

		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p><blockquote><p>blockquote</p></blockquote><p>second paragraph</p><p>third paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p><blockquote><p>blockquote</p></blockquote><p>second paragraph</p><p>inserted paragraph</p><p>third paragraph</p></div><p>paragraph</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_in_blockquote() {

		$content  = "<p>first paragraph</p><blockquote><p>blockquote</p></blockquote><p>second paragraph</p>";
		$expected = "<p>first paragraph</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>second paragraph</p>";

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_in_blockquote() {

		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p><blockquote><p>blockquote</p></blockquote><p>second paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>second paragraph</p></div><p>paragraph</p>';

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent',  );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_content_with_1p() {

		$content  = "<p>first paragraph</p>";
		$expected = "<p>first paragraph</p><p>inserted paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_content_with_1p() {

		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p>inserted paragraph</p></div><p>paragraph</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_content_with_1p_insert_if_no_p_false() {

		$content  = "<p>first paragraph</p>";
		$expected = "<p>first paragraph</p>";

		$args = array( 'insert_after_p' => 2, 'insert_if_no_p' => false );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_content_with_1p_insert_if_no_p_false() {

		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p></div><p>paragraph</p>';

		$args = array( 'insert_after_p' => 2, 'insert_if_no_p' => false, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p6_content_with_2p() {

		$content  = "<p>first paragraph</p><p>second paragraph</p>";
		$expected = "<p>first paragraph</p><p>second paragraph</p><p>inserted paragraph</p>";

		$args = array( 'insert_after_p' => 6 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p6_content_with_2p() {

		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p>second paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p>second paragraph</p><p>inserted paragraph</p></div><p>paragraph</p>';

		$args = array( 'insert_after_p' => 6, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_p_with_HTML_after_p1() {
		$content  = "<p>first paragraph</p><p>second paragraph</p>";
		$expected = "<p>first paragraph</p><p><strong>inserted</strong> paragraph</p><p>second paragraph</p>";

		$args = array( 'insert_after_p' => 1 );

		$insert_content = "<strong>inserted</strong> paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_p_with_HTML_after_p1() {
		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p>second paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p><strong>inserted</strong> paragraph</p><p>second paragraph</p></div><p>paragraph</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = "<strong>inserted</strong> paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p1_content_with_no_p() {

		$content  = "<div>text text text</div>";
		$expected = "<div>text text text</div><p>inserted paragraph</p>";

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p1_content_with_no_p() {

		$content  = '<p>first paragraph</p><div id="parent">text text text</div><p>second paragraph</p>';
		$expected = '<p>first paragraph</p><div id="parent">text text text</div><p>inserted paragraph</p><p>second paragraph</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_2_insert_after_p1_content_with_no_p() {
		// If texnode without enclosing tag is encountered
		// it will be wrapped in paragraph tags.
		$content  = "text text text";
		$expected = "<p>text text text</p><p>inserted paragraph</p>";

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p1_content_with_malformed_HTML() {

		$content  = '<div>text text text<p>first paragraph</p>';
		$expected = '<div>text text text<p>first paragraph</p><p>inserted paragraph</p>';

		$args = array( 'insert_after_p' => 2 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p1_content_with_malformed_HTML() {
		// Adds a closing div tag
		$content  = '<div id="parent">text text text<p>first paragraph</p>';
		$expected = '<div id="parent">text text text<p>first paragraph</p><p>inserted paragraph</p></div>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_malformed_HTML_after_content_p1() {
		// Adds a closing strong tag
		$content  = '<p>first paragraph</p><p>second paragraph</p>';
		$expected = '<p>first paragraph</p><p><strong>inserted paragraph</strong></p><p>second paragraph</p>';

		$args = array( 'insert_after_p' => 1 );

		$insert_content = "<strong>inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_malformed_HTML_after_content_p1() {
		// Adds a closing strong tag
		$content  = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p>second paragraph</p></div><p>paragraph</p>';
		$expected = '<p>paragraph</p><div id="parent"><p>first paragraph</p><p><strong>inserted paragraph</strong></p><p>second paragraph</p></div><p>paragraph</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = "<strong>inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_encoding_utf8() {
		// Checks if content is encoded utf-8
		$content = '<p>イリノイ州シカゴにて、アイルランド系の家庭に、9</p><p>2</p>';
		$expected = '<p>イリノイ州シカゴにて、アイルランド系の家庭に、9</p><p>inserted paragraph</p><p>2</p>';

		$args = array( 'insert_after_p' => 1 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_element_arg() {

		$content  = "<p>first paragraph</p><p>second paragraph</p>";
		$expected = "<p>first paragraph</p><div>inserted div</div><p>second paragraph</p>";

		$args = array( 'insert_element' => 'div' );

		$insert_content = "inserted div";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_empty_insert_element_arg() {

		$content  = "<p>first paragraph</p><p>second paragraph</p>";
		$expected = "<p>first paragraph</p><p>inserted div</p><p>second paragraph</p>";

		$args = array( 'insert_element' => '' );

		$insert_content = "inserted div";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_empty_content() {

		$content  = '';
		$expected = '<p>inserted paragraph</p>';

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_empty_content() {

		$content  = '<div id="parent"></div><p>paragraph</p>';
		$expected = '<div id="parent"></div><p>inserted paragraph</p><p>paragraph</p>';

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_every_2_p() {

		$content  = "<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>";
		$expected = "<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p><p>4</p><p>inserted paragraph</p><p>5</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_every_2_p_insert_element() {

		$content  = "<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p>";
		$expected = "<p>1</p><p>2</p><div>inserted paragraph</div><p>3</p><p>4</p><div>inserted paragraph</div><p>5</p>";

		$args = array( 	'insert_every_p' => 2, 'insert_element' => 'div' );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_every_1_p() {

		$content  = "<p>1</p><p>2</p><p>3</p>";
		$expected = "<p>1</p><p>inserted paragraph</p><p>2</p><p>inserted paragraph</p><p>3</p><p>inserted paragraph</p>";

		$args = array( 	'insert_every_p' => 1 );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_every_2_p_three_paragraphs() {

		$content  = "<p>1</p><p>2</p><p>3</p>";
		$expected = "<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_every_2_p_one_paragraph() {

		$content  = "<p>1</p>";
		$expected = "<p>1</p><p>inserted paragraph</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_every_2_p_no_paragraphs() {

		$content  = "<div>1</div>";
		$expected = "<div>1</div><p>inserted paragraph</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_not_insert_after_every_2_p_no_paragraphs() {

		$content  = "<div>1</div>";
		$expected = "<div>1</div>";

		$args = array( 	'insert_every_p' => 2, 'insert_if_no_p' => false );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_every_2_p_with_child() {

		$content  = "<p>1</p><p>2</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>5</p>";
		$expected = "<p>1</p><p>2</p><p>inserted paragraph</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>inserted paragraph</p><p>5</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_every_2_p_parent_element() {

		$content  = '<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>3</p><p>4</p></div><p>3</p>';
		$expected = '<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>inserted paragraph</p><p>3</p><p>4</p><p>inserted paragraph</p></div><p>3</p>';

		$args = array( 	'insert_every_p' => 2, 'parent_element_id' => 'my-id' );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	function strip_ws( $txt ) {
		$lines = explode( "\n", $txt );
		$result = array();
		foreach ( $lines as $line ) {
			if ( trim( $line ) ) {
				$result[] = trim( $line );
			}
		}

		return trim( join( "", $result ) );
	}
}
