# Insert Content Between HTML Paragraphs [![Build Status](https://travis-ci.org/keesiemeijer/insert-content.svg?branch=master)](http://travis-ci.org/keesiemeijer/insert-content) #

PHP functions to insert content between or after HTML paragraphs the right way, ***without*** using regular expressions.

Insert content in a string containing HTML markup. The PHP [DOM module](https://secure.php.net/manual/en/book.dom.php) is used to find and add the content after paragraphs.

**Note**: These functions are not intended for inserting content in full HTML pages (with a doctype, head and body).

## Features
* Insert content after the middle paragraph (default)
* Insert content after a set number of paragraphs
* Exclude nested paragraphs (default)
* Inserted content can contain HTML as well. 

### Nested Paragraphs
Only top-level (non nested) HTML paragraphs are used to add content after. Let's say you wanted to add content after the second paragraph in this content.

```html
<div>a div with content</div>
<p>first top-level paragraph</p>
<blockquote>
	<p>This is a nested paragraph</p><!-- not a top-level paragraph -->
</blockquote>
<p>second top-level paragraph</p>
<!-- Content should be inserted here -->
<p>third top-level paragraph</p>
```

Most functions (or scripts) that are similar to this one would wrongly add your content ater the second `<p>` inside the `<blockquote>` element.
* Set the `top_level_p_only` [argument](https://github.com/keesiemeijer/insert-content#parameters) to `false` to include nested paragraphs as well.
* Use the `parent_element_id` [argument](https://github.com/keesiemeijer/insert-content#parameters) to only include top-level paragraphs (nested) in an HTML element with a specific id. Set the `top_level_p_only` attribute (from above) to false to also include nested paragraphs found in that HTML element.

### Insert Position
By default content is inserted after the middle paragraph. In other words, if the HTML content contains four paragraphs it will be inserted after the second.
* Use the `insert_after_p` [argument](https://github.com/keesiemeijer/insert-content#parameters) to insert content after a number of paragraphs instead of in the middle.

### No Paragraphs Found
The content you want to insert will be added at the end if no paragraphs were found. Equally so, if you've set it to insert content after a set number of paragraphs, and not enough paragraphs were found, it's inserted after the last found paragraph. If you're using the `parent_element_id` argument and no paragraphs are found in that element the content will be inserted after the parent element.
* Set the `insert_if_no_p` [argument](https://github.com/keesiemeijer/insert-content#parameters) to false to not append content if no (or not enough) paragraphs are found.

### Inserted Content
The inserted content will be wrapped in a HTML paragraph element `<p></p>` by default.
* Use the `insert_element` [argument](https://github.com/keesiemeijer/insert-content#parameters) to wrap the inserted content in any other block-level HTML element.

## Usage
Include the `insert-content.php` file in your project to make use of the `insert_content()` function.

```php
<?php
require 'path/to/insert-content.php';

echo keesiemeijer\Insert_Content\insert_content( $content, $insert_content, $args ); 
?>
```

The defaults for the optional arguments ($args) are:
```php
$args = array(
	'parent_element_id' => '',
	'insert_element'   => 'p',
	'insert_after_p'   => '',
	'insert_if_no_p'   => true,
	'top_level_p_only' => true,
);
```

### Parameters

* `$content` (string)(required) String of content (with paragraphs) you want to add content in between.
* `$insert_content` (string) String of content you want to insert.
* `$args` (array) Array with optional arguments
  * `parent_element_id` (string) Parent element id (without #) to search paragraphs in.
  Default: empty string. Search for paragraphs in the entire content.
  * `insert_element` (string) Block-level HTML element the inserted content (`$insert_content`) is wrapped in.
  Default: 'p'. (e.g. 'p', 'div', etc.)
  * `insert_after_p` (int) Insert content after a number of paragraphs.
  Default: empty string. The content is inserted after the middle paragraph.
  * `insert_if_no_p` (boolean) Insert content even if the required number of paragraphs from `insert_after_p` (above) are not found.
  Default: true. Insert after the last paragraph. (inserts after the content if no paragraphs are found).
  * `top_level_p_only` (boolean) Insert content after top level paragraphs only.
  Default: true (recommended)

## Examples
### Example 1
Add content after the second paragraph in this content:
```html
<div>a div with content</div>
<p>first top-level paragraph</p>
<blockquote>
	<p>This is a nested paragraph</p><!-- not a top-level paragraph -->
</blockquote>
<p>second top-level paragraph</p>
<p>third top-level paragraph</p>
```

For this example pretend the above HTML content is stored inside the `$content` variable.

```php
<?php
$args = array(
	'insert_after_p' => 2, // Insert after the second paragraph
);

// Content you want to insert (without the parent element HTML tag)
$insert_content = 'I was inserted after the <strong>second</strong> paragraph';

echo keesiemeijer\Insert_Content\insert_content( $content, $insert_content, $args );
?>
```

The output for this example is this.
```html
<div>a div with content</div>
<p>first top-level paragraph</p>
<blockquote>
	<p>This is a nested paragraph</p><!-- not a top-level paragraph -->
</blockquote>
<p>second top-level paragraph</p>
<p>I was inserted after the <strong>second</strong> paragraph</p>
<p>third top-level paragraph</p>
```

### Example 2
Add content after the second paragraph in an HTML element with the id `specific-id`.

```html
<p>first paragraph</p>
<p>second paragraph</p>
<div id='specific-id'>
	<p>first top-level paragraph inside the targeted element</p>
	<p>second top-level paragraph inside the targeted element</p>
	<p>third top-level paragraph inside the targeted element</p>
</div>
<p>third paragraph</p>
```

For this example pretend the above HTML content is stored inside the `$content` variable.

```php
<?php
$args = array(
	'parent_element_id' => 'specific-id'
	'insert_after_p'    => 2, // Insert after the second paragraph
);

// Content you want to insert (without the parent element HTML tag)
$insert_content = 'I was inserted after the <strong>second</strong> paragraph inside the targeted element';

echo keesiemeijer\Insert_Content\insert_content( $content, $insert_content, $args );
?>
```

The output for this example is this.
```html
<p>first paragraph</p>
<p>second paragraph</p>
<div id='specific-id'>
	<p>first top-level paragraph inside the targeted element</p>
	<p>second top-level paragraph inside the targeted element</p>
	<p>I was inserted after the <strong>second</strong> paragraph inside the targeted element</p>
	<p>third top-level paragraph inside the targeted element</p>
</div>
<p>third paragraph</p>
```