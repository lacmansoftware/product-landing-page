import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import { Icon } from '../../components';
import edit from './edit';
import save from './save';
import attributes from './attributes.js';

registerBlockType(
	'blockart/button',
	{
		title: __( 'Button', 'blockart' ),
		description: __( 'Redirect users to your important pages or websites by clicking buttons.', 'blockart' ),
		category: 'blockart',
		keywords: [ __( 'Button', 'blockart' ), __( 'Icon', 'blockart' ) ],
		icon: <Icon type="blockIcon" name="button" size={ 24 } />,
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
