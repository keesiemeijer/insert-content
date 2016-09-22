<?php
namespace keesiemeijer\Insert_Content;

/**
 * Insert Content Between HTML Paragraphs.
 *
 * Use these functions to insert content after a number of paragraphs in a string containing HTML (with paragraphs).
 * These functions are not intended for inserting content in full HTML pages (with a doctype, head and body).
 * The content you want to insert can contain HTML as well.
 *
 * License: GPL-2.0+
 *
 * Insert Content Between HTML Paragraphs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Additional Content is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Additional Content. If not, see <http://www.gnu.org/licenses/>.
 */


/**
 * Insert content in HTML (containing paragraphs).
 *
 * By default content is inserted in the middle of all paragraphs.
 * i.e. If the HTML contains two paragraphs it will be inserted after the first.
 *
 * If no paragraphs are found in the HTML the inserted contend will be appended to the HTML.
 *
 * Note: The content you want to insert will be wrapped a HTML paragraph element (<p></p>) by default.
 *       Use the $args['parent_element'] parameter to change it to another Block-level HTML element.
 *
 * @param string  $content        String of content (with paragraphs) where you want to insert content in.
 * @param string  $insert_content String of content you want to insert.
 * @param array   $args           {
 *     Optional. Array with optional arguments.
 *
 *     @type string    $parent_element        Block-level HTML element the inserted content ($insert_content) is wrapped in.
 *                                            Default 'p'. (e.g. 'p', 'div', etc.)
 *     @type int       $insert_after_p        Insert content after a number of paragraphs.
 *                                            Default empty string. The content is inserted after the middle paragraph.
 *     @type bool      $insert_if_no_p        Insert content even if the required number of paragraphs from 'insert_after_p' (above) are not found.
 *                                            Default true. Insert after the last paragraph.
 *                                            Or insert after the content if no paragraphs are found.
 *     @type bool      $top_level_p_only      Insert content after top level paragraphs only.
 *                                            Default true (recommended)
 * }
 * @return string      String with inserted content.
 */
function insert_content( $content, $insert_content = '', $args = array() ) {

	$args = array_merge( get_defaults(), (array) $args );

	if ( empty( $insert_content ) ) {
		// Nothing to insert.
		return $content;
	}

	$args['insert_after_p'] = abs( intval( $args['insert_after_p'] ) );
	$args['parent_element'] = !empty( $args['parent_element'] ) ? $args['parent_element'] : 'p';

	// Content with parent HTML element to be inserted.
	$insert_content = "<{$args['parent_element']}>{$insert_content}</{$args['parent_element']}>";

	$nodes = new \DOMDocument();

	// Load the HTML nodes from the content.
	@$nodes->loadHTML( $content );

	// Get all paragraphs from the content.
	$p = $nodes->getElementsByTagName( 'p' );

	// Get paragraph indexes
	$nodelist = get_node_indexes( $p, $args );

	// Check if paragraphs are found.
	if ( !empty( $nodelist ) ) {

		$insert_nodes = new \DOMDocument();

		// Load the nodes from the content that's inserted.
		// Using loadHTML() here allows for malformed HTML.
		@$insert_nodes->loadHTML( $insert_content );

		$parent_node = $insert_nodes->getElementsByTagName( $args['parent_element'] )->item( 0 );
		if ( !$parent_node ) {
			return $content;
		}

		// Get the index to insert content after.
		$insert_index = get_insert_index( $nodelist, $args );

		if ( false === $insert_index ) {
			return $content;
		}

		$insert_node  = $p->item( $nodelist[ $insert_index ] );
		$next_sibling = $insert_node->nextSibling;

		if ( $next_sibling ) {
			// get sibling element (exluding text nodes and whitespace).
			$next_sibling = nextElementSibling( $insert_node );
		}

		if ( $next_sibling ) {
			// Insert before next sibling.
			$next_sibling->parentNode->insertBefore( $nodes->importNode( $parent_node, true ), $next_sibling );
		} else {
			// Insert as child of parent element.
			$insert_node->parentNode->appendChild( $nodes->importNode( $parent_node, true ) );
		}

		$html = get_HTML( $nodes );

		if ( $html ) {
			$content = $html;
		}
	} else {
		// Insert HTML after content if no paragraphs are found.
		if ( (bool) $args['insert_if_no_p'] ) {
			$content .= $insert_content;
		}
	}

	return $content;
}

/**
 * Get default arguments.
 *
 * @return array Array with default arguments.
 */
function get_defaults() {
	return array(
		'parent_element'   => 'p',
		'insert_after_p'   => '',
		'insert_if_no_p'   => true,
		'top_level_p_only' => true,
	);
}

/**
 * Returns indexes from a DOMNodeList instance containing HTML paragraphs.
 * Nested HTML paragraphs are excluded if $args['top_level_p_only'] is set to true.
 *
 * @param object  $nodes DOMNodeList instance containing all the p elements.
 * @param array   $args  Optional arguments. See: get_defaults().
 * @return array         Array with HTML paragraph indexes.
 */
function get_node_indexes( $nodes, $args ) {
	$args     = array_merge( get_defaults(), (array) $args );
	$nodelist = array();
	$length = $nodes->length;
	for ( $i = 0; $i < $length; ++$i ) {
		$nodelist[] = $i;
		if ( (bool) $args['top_level_p_only'] && 'body' !== $nodes->item( $i )->parentNode->nodeName ) {
			// Remove nested paragraphs from the list.
			unset( $nodelist[ $i ] );
		}
	}
	return array_values( $nodelist );
}

/**
 * Returns the index (paragraph) to insert content after.
 * Uses $args['insert_after_p'] to calculate the index.
 *
 * @param array   $nodelist Array with HTML paragraph indexes.
 * @param array   $args     Optional arguments. See: get_defaults().
 * @return int|false        Index of the (paragraph) node or false.
 */
function get_insert_index( $nodelist, $args ) {

	if ( empty( $nodelist ) ) {
		return false;
	}

	$args = array_merge( get_defaults(), (array) $args );

	end( $nodelist );

	$last         = key( $nodelist );
	$last_index   = $nodelist[ $last ];
	$count        = count( $nodelist );
	$insert_index = abs( intval( $args['insert_after_p'] ) );

	reset( $nodelist );

	if ( !$insert_index ) {

		if ( 1 < $count ) {
			// More than one paragraph found.
			// Get middle position to insert the HTML.
			$insert_index = floor( $count / 2 ) -1;
		} else {
			// One paragraph
			$insert_index = $last_index;
		}
	} else {
		// start counting at 0.
		--$insert_index;
		--$count;

		if ( $insert_index > $count  ) {
			if ( $args['insert_if_no_p'] ) {
				// insert after last paragraph.
				$insert_index = $last_index;
			} else {
				return false;
			}
		}
	}

	return $insert_index;
}

/**
 * Returns the next sibling of a node.
 *
 * @param object  $node DOMElement object
 * @return object       sibling object
 */
function nextElementSibling( $node ) {

	while ( $node && ( $node = $node->nextSibling ) ) {
		if ( $node instanceof \DOMElement ) {
			break;
		}
	}
	return $node;
}

/**
 * Returns the HTML from a DOMDocument object as a string.
 * Returns only the HTML from the body element (added by DOMDocument->saveHTML()).
 *
 * @param object  $nodes DOMDocument object.
 * @return string        Html.
 */
function get_HTML( $nodes ) {
	$body_node = $nodes->getElementsByTagName( 'body' )->item( 0 );

	if ( $body_node ) {
		// Convert nodes from the body element to a string containing HTML.
		$content = $nodes->saveHTML( $body_node );
		// Remove first body element only.
		$replace_count = 1;

		return str_replace( array( '<body>', '</body>' ) , array( '', '' ), $content, $replace_count );
	}

	return '';
}
