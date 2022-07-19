import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import edit from './edit';
import save from './save';
import attributes from './attributes';
import { Icon } from '../../../components';

registerBlockType(
	'blockart/column',
	{
		title: __( 'Column', 'blockart' ),
		description: __( 'An advanced single column within section block.', 'blockart' ),
		category: 'blockart',
		icon: <Icon type="blockIcon" name="column" size={ 24 } />,
		parent: [ 'blockart/section' ],
		supports: { className: false, inserter: false, reusable: false, html: false },
		attributes,
		edit,
		save,
	}
);
