import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import { Icon } from '../../components';
import edit from './edit';
import save from './save';
import attributes from './attributes.js';
import './style.scss';
import './editor.scss';

registerBlockType(
	'blockart/spacing',
	{
		title: __( 'Spacing', 'blockart' ),
		description: __( 'Give your designs room to breathe with white space.', 'blockart' ),
		icon: <Icon type="blockIcon" name="spacing" size={ 24 } />,
		category: 'blockart',
		keywords: [ __( 'Spacing', 'blockart' ), __( 'Spacer', 'blockart' ), __( 'Divider', 'blockart' ) ],
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
