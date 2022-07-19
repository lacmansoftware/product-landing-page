import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import { Icon } from '../../components';
import edit from './edit';
import save from './save';
import attributes from './attributes.js';
import './editor.scss';

registerBlockType(
	'blockart/paragraph',
	{
		title: __( 'Paragraph', 'blockart' ),
		description: __( 'Customize typography and style paragraphs with multiple setting options.', 'blockart' ),
		icon: <Icon type="blockIcon" name="paragraph" size={ 24 } />,
		category: 'blockart',
		keywords: [ __( 'Paragraph', 'blockart' ) ],
		attributes,
		example: {
			attributes: {},
		},
		supports: {
			className: false,
			align: false,
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
