# Insert Content Between HTML Paragraphs [![Build Status](https://travis-ci.org/keesiemeijer/insert-content.svg?branch=master)](http://travis-ci.org/keesiemeijer/insert-content) #

PHP functions to insert content between or after HTML paragraphs the right way, without using regular expressions.

Insert content (like ads or related posts) to a string that's already formatted with HTML markup. The PHP [DOM module](https://secure.php.net/manual/en/book.dom.php) is used to add content after paragraphs

## Features
* Insert content after the middle paragraph (default)
* Insert content after a set number of paragraphs

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

Most funtions (or scripts) that are similar to this one would wrongly add your content inside the `<blockquote>` element.
* Use the `top_level_p_only` parameter to include nested paragraphs as well.

### Insert Position
By default content is inserted in the middle of all paragraphs. In other words, if the HTML content contains four paragraphs it will be inserted after the second. 
* Use the `insert_after_p` parameter to insert content after a number of paragraphs instead of in the middle.

### No Paragraphs Found
The content you want to insert will be added to the end if no paragraphs were found to add content to.
* Use the `insert_if_no_p` parameter to not append content if no paragraphs are found.

### Parent HTML Element For Inserted Content
The inserted content will be wrapped in a HTML paragraph element `<p></p>` by default.
* Use the `parent_element` parameter to wrap the inserted content in any other block-level HTML element.

As a bonus the content you want to insert can contain HTML as well.

**Note**: These functions are not intended for inserting content in full HTML pages (with a doctype, head and body). They are for inserting content after a number of paragraphs in a string containing HTML (with paragraphs), like blog post content.

## Usage
Include the `insert-content.php` file in your project to make use of the `insert_content()` fuction.

```php
<?php echo keesiemeijer\Insert_Content\insert_content( $content, $insert_content, $args ); ?>
```

The default optional arguments are:
```php
$args = array(
	'parent_element'   => 'p',
	'insert_after_p'   => '',
	'insert_if_no_p'   => true,
	'top_level_p_only' => true,
);
```

### Parameters

* `$content` (string)(required) String of content (with paragraphs) you want to add content in between.
* `$insert_content` (string) String of content you want to insert.
* `$args` (array) Array with optional arguments
  * `parent_element` (string) Block-level HTML element the inserted content (`$insert_content`) is wrapped in.
  Default: 'p'. (e.g. 'p', 'div', etc.)
  * `insert_after_p` (int) Insert content after a number of paragraphs.
  Default: empty string. The content is inserted after the middle paragraph.
  * `insert_if_no_p` (boolean) Insert content even if the required number of paragraphs from `insert_after_p` (above) are not found.
  Default: true. Insert after the last paragraph. (inserts after the content if no paragraphs are found).
  * `top_level_p_only` (boolean) Insert content after top level paragraphs only.
  Default: true (recommended)

## Example
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
$insert_content = 'I was inserted after the second paragraph';

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
<p>I was inserted after the second paragraph</p>
<p>third top-level paragraph</p>
```