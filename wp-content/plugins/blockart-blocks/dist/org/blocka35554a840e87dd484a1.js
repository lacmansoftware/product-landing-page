import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import { Icon } from '../../components';
import edit from './edit';
import save from './save';
import attributes from './attributes.js';

registerBlockType(
	'blockart/heading',
	{
		title: __( 'Heading', 'blockart' ),
		description: __( 'Create stylish title for each section with various markups from H1 to H6.', 'blockart' ),
		icon: <Icon type="blockIcon" name="heading" size={ 24 } />,
		category: 'blockart',
		keywords: [ __( 'Heading', 'blockart' ), __( 'Headline', 'blockart' ) ],
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
