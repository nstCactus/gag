/**
 * Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// This file contains style definitions that can be used by CKEditor plugins.
//
// The most common use for it is the "stylescombo" plugin, which shows a combo
// in the editor toolbar, containing all styles. Other plugins instead, like
// the div plugin, use a subset of the styles on their feature.
//
// If you don't have plugins that depend on this file, you can simply ignore it.
// Otherwise it is strongly recommended to customize this file to match your
// website requirements and design properly.

CKEDITOR.stylesSet.add('default', [
    /* Block Styles */
    {
        name: 'Title',
        element: 'h2',
    },
    {
        name: 'Subtitle',
        element: 'h3',
    },
    {
        name: 'Paragraph',
        element: 'p',
    },

    /* Object Styles */
    {
        name: 'Block quote: block',
        element: 'div',
        attributes: {
            class: 'Ck_bloquote'
        },
    },
    {
        name: 'Block quote: quote',
        element: 'blockquote',
        attributes: {
            class: 'Ck_bloquoteDesc'
        },
    },
    {
        name: 'Block quote: author',
        element: 'div',
        attributes: {
            class: 'Ck_bloquoteAuthor'
        },
    },
    {
        name: 'External link',
        element: 'a',
        attributes: {
            'class': 'LinkWithIcon LinkWithIcon-external'
        }
    },
    {
        name: 'Internal link',
        element: 'a',
        attributes: {
            'class': 'LinkWithIcon LinkWithIcon-arrow'
        }
    },
    {
        name: 'Document link',
        element: 'a',
        attributes: {
            'class': 'LinkWithIcon LinkWithIcon-doc'
        }
    },
    {
        name: 'Button',
        element: 'a',
        attributes: {
            'class': 'Button'
        }
    },
]);

