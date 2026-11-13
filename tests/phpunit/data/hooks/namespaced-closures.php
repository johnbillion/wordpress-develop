<?php
/**
 * Anonymous functions defined in a namespace are named "Namespace\{closure}" before PHP 8.4.
 */

namespace Tests\Hooks\BuildUniqueId;

function get_closures(): array {
	return array( function (): void {}, function (): void {} );
}

class Closure_Factory {
	public function get_closures(): array {
		return array( function (): void {}, function (): void {} );
	}
}
