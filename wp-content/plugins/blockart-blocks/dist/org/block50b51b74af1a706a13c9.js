import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import { Icon } from '../../components';
import edit from './edit';
import save from './save';
import attributes from './attributes.js';

registerBlockType(
	'blockart/image',
	{
		title: __( 'Image', 'blockart' ),
		description: __( 'Visual communication with your visitor via images.', 'blockart' ),
		icon: <Icon type="blockIcon" name="image" size={ 24 } />,
		category: 'blockart',
		keywords: [ __( 'Image', 'blockart' ) ],
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
