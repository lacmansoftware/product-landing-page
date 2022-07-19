<?php
namespace Depicter\Document\Models\Elements;

use Averta\Core\Utility\Arr;
use Depicter\Document\Models;
use Depicter\Html\Html;

class Text extends Models\Element
{

	public function render() {
		$tag = $this->options->tag ?? 'p';

		$content = $this->maybeReplaceDataSheetTags( $this->options->content );
		$content = str_replace("\n", "<br>", $content);

		$args = $this->getDefaultAttributes();

		$output =  Html::$tag($args, $content );

		if ( false !== $a = $this->getLinkTag() ) {
			return $a->nest( $output ) . "\n";
		}
		return $output . "\n";
	}
}
