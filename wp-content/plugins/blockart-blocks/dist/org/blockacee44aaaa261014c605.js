import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import { Icon } from '../../components';
import edit from './edit';
import save from './save';
import attributes from './attributes.js';
import './editor.scss';
import './style.scss';

registerBlockType(
	'blockart/section',
	{
		title: __( 'Section', 'blockart' ),
		description: __( 'Add Rows and Columns inside rows to create various layouts.', 'blockart' ),
		icon: <Icon type="blockIcon" name="section" size={ 24 } />,
		category: 'blockart',
		keywords: [ __( 'Section', 'blockart' ), __( 'Columns', 'blockart' ), __( 'Layout', 'blockart' ) ],
		attributes,
		example: {
			attributes: {},
		},
		supports: {
			className: false,
			align: [ 'center', 'wide', 'full' ],
			color: {
				background: false,
				gradient: false,
				text: false,
			},
		},
		edit,
		save,
	}
);
