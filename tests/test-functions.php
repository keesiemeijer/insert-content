<?php
namespace keesiemeijer\Insert_Content;

class Insert_Content_Test extends \PHPUnit\Framework\TestCase {
	public function setUp() { }
	public function tearDown() { }

	public function test_insert_middle() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><p>inserted paragraph</p><p>2</p>";

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_middle_array() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><p>inserted paragraph</p><p>2</p>";

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_middle_content_1p() {
		$content  = "<p>1</p>";
		$expected = "<p>1</p><p>inserted paragraph</p>";

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_middle_content_1p_array() {
		$content  = "<p>1</p>";
		$expected = "<p>1</p><p>inserted paragraph</p>";

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_middle_content_1p() {
		$content  = '<p>text</p><div id="parent"><p>1</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>';

		$args = array( 'parent_element_id' => 'parent' );
		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_middle_content_1p_array() {
		$content  = '<p>text</p><div id="parent"><p>1</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>';

		$args = array( 'parent_element_id' => 'parent' );
		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}


	public function test_insert_after_p2() {
		$content  = "<p>1</p><p>2</p><p>third paragraph</p>";
		$expected = "<p>1</p><p>2</p><p>inserted paragraph</p><p>third paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_array() {
		$content  = "<p>1</p><p>2</p><p>third paragraph</p>";
		$expected = "<p>1</p><p>2</p><p>inserted paragraph</p><p>third paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2() {
		$content  = '<p>text</p><div id="parent"><p>1</p><p>2</p><p>third paragraph</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p><p>third paragraph</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_array() {
		$content  = '<p>text</p><div id="parent"><p>1</p><p>2</p><p>third paragraph</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p><p>third paragraph</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_with_child_p() {
		$content  = "<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>third paragraph</p>";
		$expected = "<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>third paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_with_child_p_array() {
		$content  = "<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>third paragraph</p>";
		$expected = "<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>third paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_with_child_p() {
		$content  = '<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>third paragraph</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>third paragraph</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_with_child_p_array() {
		$content  = '<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>third paragraph</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p><p>inserted paragraph</p><p>third paragraph</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_in_blockquote() {
		$content  = "<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p>";
		$expected = "<p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p>";

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_in_blockquote_array() {
		$content  = "<p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p>";
		$expected = "<p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p>";

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_in_blockquote() {
		$content  = '<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent',  );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_in_blockquote_array() {
		$content  = '<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p></blockquote><p>2</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><blockquote><p>blockquote</p><p>inserted paragraph</p></blockquote><p>2</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent',  );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_content_with_1p() {
		$content  = "<p>1</p>";
		$expected = "<p>1</p><p>inserted paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_content_with_1p_array() {
		$content  = "<p>1</p>";
		$expected = "<p>1</p><p>inserted paragraph</p>";

		$args = array( 'insert_after_p' => 2 );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_content_with_1p() {
		$content  = '<p>text</p><div id="parent"><p>1</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_content_with_1p_array() {
		$content  = '<p>text</p><div id="parent"><p>1</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p>inserted paragraph</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_content_with_1p_insert_if_no_p_false() {
		$content  = "<p>1</p>";
		$expected = "<p>1</p>";

		$args = array( 'insert_after_p' => 2, 'insert_if_no_p' => false );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p2_content_with_1p_insert_if_no_p_false_array() {
		$content  = "<p>1</p>";
		$expected = "<p>1</p>";

		$args = array( 'insert_after_p' => 2, 'insert_if_no_p' => false );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_content_with_1p_insert_if_no_p_false() {
		$content  = '<p>text</p><div id="parent"><p>1</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'insert_if_no_p' => false, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_content_with_1p_insert_if_no_p_false_array() {
		$content  = '<p>text</p><div id="parent"><p>1</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'insert_if_no_p' => false, 'parent_element_id' => 'parent' );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p6_content_with_2p() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><p>2</p><p>inserted paragraph</p>";

		$args = array( 'insert_after_p' => 6 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p6_content_with_2p_array() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><p>2</p><p>inserted paragraph</p>";

		$args = array( 'insert_after_p' => 6 );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p6_content_with_2p() {
		$content  = '<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 6, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p6_content_with_2p_array() {
		$content  = '<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p>2</p><p>inserted paragraph</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 6, 'parent_element_id' => 'parent' );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_p_with_HTML_after_p1() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p>";

		$args = array( 'insert_after_p' => 1 );

		$insert_content = "<strong>inserted</strong> paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_p_with_HTML_after_p1_array() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p>";

		$args = array( 'insert_after_p' => 1 );

		$insert_content = array("<strong>inserted</strong> paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_p_with_HTML_after_p1() {
		$content  = '<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = "<strong>inserted</strong> paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_p_with_HTML_after_p1_array() {
		$content  = '<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p><strong>inserted</strong> paragraph</p><p>2</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = array("<strong>inserted</strong> paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p1_content_with_no_p() {
		$content  = "<div>content</div>";
		$expected = "<div>content</div><p>inserted paragraph</p>";

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p1_content_with_no_p_array() {
		$content  = "<div>content</div>";
		$expected = "<div>content</div><p>inserted paragraph</p>";

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p1_content_with_no_p() {
		$content  = '<p>1</p><div id="parent">content</div><p>2</p>';
		$expected = '<p>1</p><div id="parent">content</div><p>inserted paragraph</p><p>2</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p1_content_with_no_p_array() {
		$content  = '<p>1</p><div id="parent">content</div><p>2</p>';
		$expected = '<p>1</p><div id="parent">content</div><p>inserted paragraph</p><p>2</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_2_insert_after_p1_content_with_no_p() {
		// If texnode without enclosing tag is encountered
		// it will be wrapped in paragraph tags.
		$content  = "content";
		$expected = "<p>content</p><p>inserted paragraph</p>";

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_2_insert_after_p1_content_with_no_p_array() {
		// If texnode without enclosing tag is encountered
		// it will be wrapped in paragraph tags.
		$content  = "content";
		$expected = "<p>content</p><p>inserted paragraph</p>";

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p1_content_with_malformed_HTML() {
		$content  = '<div>content<p>1</p>';
		$expected = '<div>content<p>1</p><p>inserted paragraph</p>';

		$args = array( 'insert_after_p' => 2 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_after_p1_content_with_malformed_HTML_array() {
		$content  = '<div>content<p>1</p>';
		$expected = '<div>content<p>1</p><p>inserted paragraph</p>';

		$args = array( 'insert_after_p' => 2 );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p1_content_with_malformed_HTML() {
		// Adds a closing div tag
		$content  = '<div id="parent">content<p>1</p>';
		$expected = '<div id="parent">content<p>1</p><p>inserted paragraph</p></div>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p1_content_with_malformed_HTML_array() {
		// Adds a closing div tag
		$content  = '<div id="parent">content<p>1</p>';
		$expected = '<div id="parent">content<p>1</p><p>inserted paragraph</p></div>';

		$args = array( 'insert_after_p' => 2, 'parent_element_id' => 'parent' );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_malformed_HTML_after_content_p1() {
		// Adds a closing strong tag
		$content  = '<p>1</p><p>2</p>';
		$expected = '<p>1</p><p><strong>inserted paragraph</strong></p><p>2</p>';

		$args = array( 'insert_after_p' => 1 );

		$insert_content = "<strong>inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_malformed_HTML_after_content_p1_array() {
		// Adds a closing strong tag
		$content  = '<p>1</p><p>2</p>';
		$expected = '<p>1</p><p><strong>inserted paragraph</strong></p><p>2</p>';

		$args = array( 'insert_after_p' => 1 );

		$insert_content = array("<strong>inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_malformed_HTML_after_content_p1() {
		// Adds a closing strong tag
		$content  = '<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p><strong>inserted paragraph</strong></p><p>2</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = "<strong>inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_malformed_HTML_after_content_p1_array() {
		// Adds a closing strong tag
		$content  = '<p>text</p><div id="parent"><p>1</p><p>2</p></div><p>text</p>';
		$expected = '<p>text</p><div id="parent"><p>1</p><p><strong>inserted paragraph</strong></p><p>2</p></div><p>text</p>';

		$args = array( 'insert_after_p' => 1, 'parent_element_id' => 'parent' );

		$insert_content = array("<strong>inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_encoding_utf8() {
		// Checks if content is encoded utf-8
		$content = '<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>2</p>';
		$expected = '<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>inserted paragraph</p><p>2</p>';

		$args = array( 'insert_after_p' => 1 );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_encoding_utf8_array() {
		// Checks if content is encoded utf-8
		$content = '<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>2</p>';
		$expected = '<p>イリノイ州シカゴにて、アイルランド系の家庭に、9 äöüß</p><p>inserted paragraph</p><p>2</p>';

		$args = array( 'insert_after_p' => 1 );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_encoding_utf8_no_p() {
		// Checks if content is encoded utf-8
		$content = '<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div>';
		$expected = '<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div><p>äöüß</p>';

		$insert_content = "äöüß";
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_encoding_utf8_no_p_array() {
		// Checks if content is encoded utf-8
		$content = '<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div>';
		$expected = '<div>イリノイ州シカゴにて、アイルランド系の家庭に、9</div><p>äöüß</p>';

		$insert_content = array("äöüß", "second paragraph");
		$insert         = insert_content( $content, $insert_content );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_element_arg() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><div>inserted div</div><p>2</p>";

		$args = array( 'insert_element' => 'div' );

		$insert_content = "inserted div";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_insert_element_arg_array() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><div>inserted div</div><p>2</p>";

		$args = array( 'insert_element' => 'div' );

		$insert_content = array("inserted div", "second div");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_empty_insert_element_arg() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><p>inserted div</p><p>2</p>";

		$args = array( 'insert_element' => '' );

		$insert_content = "inserted div";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_empty_insert_element_arg_array() {
		$content  = "<p>1</p><p>2</p>";
		$expected = "<p>1</p><p>inserted div</p><p>2</p>";

		$args = array( 'insert_element' => '' );

		$insert_content = array("inserted div", "second div");
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

	public function test_insert_after_p2_empty_content_array() {
		$content  = '';
		$expected = '<p>inserted paragraph</p>';

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false );

		$insert_content = array("inserted paragraph", "second paragraph");
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_empty_content() {
		$content  = '<div id="parent"></div><p>text</p>';
		$expected = '<div id="parent"></div><p>inserted paragraph</p><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent' );

		$insert_content = "inserted paragraph";
		$insert         = insert_content( $content, $insert_content, $args );

		$this->assertEquals( $this->strip_ws( $expected ),  $this->strip_ws( $insert ) );
	}

	public function test_parent_id_insert_after_p2_empty_content_array() {
		$content  = '<div id="parent"></div><p>text</p>';
		$expected = '<div id="parent"></div><p>inserted paragraph</p><p>text</p>';

		$args = array( 'insert_after_p' => 2, 'top_level_p_only' => false, 'parent_element_id' => 'parent' );

		$insert_content = array("inserted paragraph", "second paragraph");
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

	public function test_insert_after_every_2_p_array() {
		$content  = "<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>";
		$expected = "<p>1</p><p>2</p><p>inserted 1</p><p>3</p><p>4</p><p>inserted 2</p><p>5</p><p>6</p><p>inserted 1</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = array("inserted 1", "inserted 2");
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

	public function test_insert_after_every_1_p_array() {
		$content  = "<p>1</p><p>2</p><p>3</p>";
		$expected = "<p>1</p><p>inserted 1</p><p>2</p><p>inserted 2</p><p>3</p><p>inserted 1</p>";

		$args = array( 	'insert_every_p' => 1 );
		$insert_content = array("inserted 1", "inserted 2");
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

	public function test_insert_after_every_2_p_three_paragraphs_array() {
		$content  = "<p>1</p><p>2</p><p>3</p>";
		$expected = "<p>1</p><p>2</p><p>inserted paragraph</p><p>3</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = array("inserted paragraph");
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

	public function test_insert_after_every_2_p_one_paragraph_array() {
		$content  = "<p>1</p>";
		$expected = "<p>1</p><p>inserted 1</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = array("inserted 1", "inserted 2");
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

	public function test_insert_after_every_2_p_no_paragraphs_array() {
		$content  = "<div>1</div>";
		$expected = "<div>1</div><p>inserted 1</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = array("inserted 1", "inserted 2");
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

	public function test_insert_after_every_2_p_with_child_array() {
		$content  = "<p>1</p><p>2</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>5</p>";
		$expected = "<p>1</p><p>2</p><p>inserted 1</p><blockquote><p>child p</p></blockquote><p>3</p><p>4</p><p>inserted 2</p><p>5</p>";

		$args = array( 	'insert_every_p' => 2 );
		$insert_content = array("inserted 1", "inserted 2");
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

	public function test_insert_after_every_2_p_parent_element_array() {
		$content  = '<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>3</p><p>4</p></div><p>3</p>';
		$expected = '<p>1</p><p>2</p><div id="my-id"><p>1</p><p>2</p><p>inserted 1</p><p>3</p><p>4</p><p>inserted 2</p></div><p>3</p>';

		$args = array( 	'insert_every_p' => 2, 'parent_element_id' => 'my-id' );
		$insert_content = array("inserted 1", "inserted 2");
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
