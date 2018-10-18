<?php
/**
 * Insert Content Between HTML Paragraphs.
 *
 * Functions to insert content after a number of HTML paragraphs in a string containing HTML (with paragraphs).
 *
 * For more information visit: https://github.com/keesiemeijer/insert-content
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
 *
 * @license GPL-2.0+
 * @author  keesiemeijer
 * @version 2.0.0
 */


namespace keesiemeijer\Insert_Content;


/**
 * Insert content in HTML (containing HTML paragraphs).
 *
 * By default content is inserted in the middle of all paragraphs.
 * i.e. If the HTML contains two paragraphs it will be inserted after the first.
 *
 * If no paragraphs are found in the HTML the inserted contend will be appended to the HTML.
 *
 * Note: The content you want to insert will be wrapped a HTML paragraph element (<p></p>) by default.
 *       Use the $args['insert_element'] parameter to change it to another Block-level HTML element.
 *
 * @param string $content        String of content (with paragraphs) where you want to insert content in.
 * @param string $insert_content String of content you want to insert.
 * @param array  $args           {
 *     Optional. Array with optional arguments.
 *
 *     @type string    $parent_element_id     Parent element id to search paragraphs in.
 *                                            Default: empty string. Search for paragraphs in the entire content.
 *     @type string    $insert_element        Block-level HTML element the inserted content ($insert_content) is wrapped in.
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
		return $content;
	}

	// Validate arguments.
	$args['parent_element_id'] = trim( (string) $args['parent_element_id'] );
	$args['insert_element']    = trim( (string) $args['insert_element'] );
	$args['insert_element']    = $args['insert_element'] ? $args['insert_element'] : 'p';
	$args['insert_after_p']    = abs( intval( $args['insert_after_p'] ) );
	$args['insert_every_p']    = abs( intval( $args['insert_every_p'] ) );
	$parent_element            = false;

	$nodes = new \DOMDocument();

	// Load the HTML nodes from the content.
	@$nodes->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );

	if ( $args['parent_element_id'] ) {
		$parent_element = $nodes->getElementById( $args['parent_element_id'] );

		if ( ! $parent_element ) {
			// Parent element not found.
			return $content;
		}

		// Get all paragraphs from the parent element.
		$p = $parent_element->getElementsByTagName( 'p' );
	} else {
		// Get all paragraphs from the content.
		$p = $nodes->getElementsByTagName( 'p' );
	}

	$insert_nodes = new \DOMDocument();

	// Content wrapped in the parent HTML element (to be inserted).
	$insert_content = "<{$args['insert_element']}>{$insert_content}</{$args['insert_element']}>";

	// Load the HTML nodes from the content to insert.
	@$insert_nodes->loadHTML( mb_convert_encoding( $insert_content, 'HTML-ENTITIES', 'UTF-8' ) );

	$insert_element = $insert_nodes->getElementsByTagName( $args['insert_element'] )->item( 0 );

	if ( ! $insert_element ) {
		return $content;
	}

	// Get paragraph indexes where content should be inserted after.
	$nodelist = get_node_indexes( $p, $args );

	// Check if paragraphs are found.
	if ( ! empty( $nodelist ) ) {

		$inserted = insert_nodes( $nodes, $insert_element, $p, $nodelist, $args );

		if ( ! $inserted ) {
			return $content;
		}

		$html = get_HTML( $nodes );
		if ( $html ) {
			$content = $html;
		}
	} else {
		// No paragraphs found.
		if ( (bool) $args['insert_if_no_p'] ) {

			if ( $parent_element ) {
				// Insert content after parent element.
				insert_content_element( $nodes, $parent_element, $insert_element );

				$html = get_HTML( $nodes );
				if ( $html ) {
					$content = $html;
				}
			} else {
				// Add insert content after the content.
				$content .= $insert_content;
			}
		}
	}

	return $content;
}

/**
 * Inserts nodes
 *
 * @param object $nodes          DOMNodeList instance containing all elements.
 * @param object $insert_element DOMElement object to insert.
 * @param object $p              DOMNodeList instance containing all the p elements.
 * @param array  $nodelist       Array with HTML paragraph indexes.
 * @param array  $args           Optional arguments. See: insert_content().
 * @return bool True if the node was inserted.
 */
function insert_nodes( $nodes, $insert_element, $p, $nodelist, $args ) {
	$_args = $args;
	if ( $args['insert_every_p'] ) {

		$node_count = count( $nodelist );
		$step       = (int) $args['insert_every_p'];

		if ( ( $step + $step ) > $node_count ) {
			$args['insert_every_p'] = '';
			$args['insert_after_p'] = $step;
			return insert_node( $nodes, $insert_element, $p, $nodelist, $args );
		}

		$inserted = false;
		$range    = range( $step, $node_count, $step );
		$range    = array_values( array_reverse( $range ) );
		foreach ( $range as $index ) {
			$_args['insert_after_p'] = $index;
			$inserted = insert_node( $nodes, $insert_element, $p, $nodelist, $_args );
			if ( ! $inserted ) {
				break;
			}
		}

		return $inserted;
	} else {
		return insert_node( $nodes, $insert_element, $p, $nodelist, $args );
	}
}

/**
 * Inserts a node.
 *
 * @param object $nodes          DOMNodeList instance containing all elements.
 * @param object $insert_element DOMElement object to insert.
 * @param object $p              DOMNodeList instance containing all the p elements.
 * @param array  $nodelist       Array with HTML paragraph indexes.
 * @param array  $args           Optional arguments. See: insert_content().
 * @return bool True if the node was inserted
 */
function insert_node( $nodes, $insert_element, $p, $nodelist, $args  ) {
	$insert_index = get_item_index( $nodelist, $args );

	if ( false === $insert_index ) {
		return false;
	}

	// Insert content after this (paragraph) node.
	$insert_node = $p->item( $insert_index );

	// Insert the nodes.
	insert_content_element( $nodes, $insert_node, $insert_element );
	return true;
}

/**
 * Get default arguments.
 *
 * @return array Array with default arguments.
 */
function get_defaults() {
	return array(
		'parent_element_id' => '',
		'insert_element'    => 'p',
		'insert_after_p'    => '',
		'insert_every_p'    => '',
		'insert_if_no_p'    => true,
		'top_level_p_only'  => true,
	);
}

/**
 * Returns indexes from a DOMNodeList instance containing HTML paragraphs.
 * Nested HTML paragraphs are excluded if $args['top_level_p_only'] is set to true.
 *
 * @param object $nodes DOMNodeList instance containing all the p elements.
 * @param array  $args  Optional arguments. See: insert_content().
 * @return array        Array with HTML paragraph indexes.
 */
function get_node_indexes( $nodes, $args ) {
	$args      = array_merge( get_defaults(), (array) $args );
	$nodelist  = array();
	$length    = isset( $nodes->length ) ? $nodes->length : 0;
	$parent_id = trim( $args['parent_element_id'] );

	for ( $i = 0; $i < $length; ++$i ) {
		$nodelist[ $i ] = $i;
		$parent         = false;
		$node           = $nodes->item( $i );

		if ( $parent_id  ) {
			if ( $node->parentNode->hasAttribute( 'id' ) ) {
				$parent_id_attr = $node->parentNode->getAttribute( 'id' );
				$parent = ( $parent_id === $parent_id_attr );
			}
		} else {
			$parent = ( 'body' === $node->parentNode->nodeName );
		}

		if ( (bool) $args['top_level_p_only'] && ! $parent ) {
			// Remove nested paragraphs from the list.
			unset( $nodelist[ $i ] );
		}
	}

	return array_values( $nodelist );
}

/**
 * Returns the index (for the paragraph) to insert content after.
 * Uses $args['insert_after_p'] to calculate the index.
 *
 * @param array $nodelist Array with HTML paragraph indexes.
 * @param array $args     Optional arguments. See: insert_content().
 * @return int|false Index of the (paragraph) node or false.
 */
function get_item_index( $nodelist, $args ) {

	if ( empty( $nodelist ) ) {
		return false;
	}

	$args         = array_merge( get_defaults(), (array) $args );
	$count        = count( $nodelist );
	$insert_index = abs( intval( $args['insert_after_p'] ) );

	end( $nodelist );
	$last = key( $nodelist );
	reset( $nodelist );

	if ( ! $insert_index ) {
		if ( 1 < $count ) {
			// More than one paragraph found.
			// Get middle position to insert the HTML.
			$insert_index = $nodelist[ floor( $count / 2 ) - 1 ];
		} else {
			// One paragraph.
			$insert_index = $last;
		}
	} else {
		// start counting at 0.
		--$insert_index;
		--$count;

		if ( $insert_index > $count  ) {
			if ( (bool) $args['insert_if_no_p'] ) {
				// insert after last paragraph.
				$insert_index = $last;
			} else {
				return false;
			}
		}
	}

	return $nodelist[ $insert_index ];
}

/**
 * Insert an element (and it's child elements) in the content.
 *
 * @param object $nodes          DOMDocument Object for the content.
 * @param object $insert_node    DOMElement object to insert nodes after.
 * @param object $insert_element DOMElement object to insert.
 * @return void
 */
function insert_content_element( $nodes, $insert_node, $insert_element ) {
	$next_sibling = isset( $insert_node->nextSibling ) ? $insert_node->nextSibling : false;

	if ( $next_sibling ) {
		// get sibling element (exluding text nodes and whitespace).
		$next_sibling = nextElementSibling( $insert_node );
	}

	if ( $next_sibling ) {
		// Insert before next sibling.
		$next_sibling->parentNode->insertBefore( $nodes->importNode( $insert_element, true ), $next_sibling );
	} else {
		// Insert as child of parent element.
		$insert_node->parentNode->appendChild( $nodes->importNode( $insert_element, true ) );
	}
}

/**
 * Returns the next sibling of a node.
 *
 * @param object $node DOMElement paragraph object.
 * @return object Next sibling object.
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
 * @param object $nodes DOMDocument Object for the content.
 * @return string Html.
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
