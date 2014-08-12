<?php

require_once('Calculator.php');
$calc = new KakuroCalculator();

function outputOptions($from, $to, $selected = null) {
	for ($i = $from; $i <= $to; $i++) {
		$extraHTML = ($selected && $selected == $i) ? ' selected="selected"' : '';
		echo '<option' . $extraHTML . '>' . $i . '</option>';
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$combinations = $calc->calculate($_POST['target'], $_POST['in']);
}

?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Kakuro Helper</title>

		<style>
			body { font-family: sans-serif; }

			select, button { font-size: 18px; }
		</style>
	</head>
	<body>
		<h2>Find Combinations for:</h2>

		<form method="post" action="">
			<select name="target"><?php outputOptions(3, $calc->getHighestPossibleNumber(), $_POST['target']); ?></select> in
			<select name="in"><?php outputOptions(2, 9, $_POST['in']); ?></select>
			<button type="submit">Get Combinations</button>
		</form>

		<?php if (isset($combinations)) { ?>
			<h3><?php echo count($combinations); ?> possible combination(s) for <?php echo $_POST['target'] . ' in ' . $_POST['in']; ?></h3>
			<ul>
				<?php foreach ($combinations as $row) { echo '<li>' . implode('+', $row) . '</li>'; } ?>
			</ul>

			<?php
				$numbers = array();
				array_walk_recursive($combinations, function ($a) use (&$numbers) {
					$numbers[] = $a;
				});
				$numbers = array_unique($numbers);
				sort($numbers);
			?>
			<p>Available numbers: <?php echo implode(', ', $numbers); ?></p>
		<?php } ?>
	</body>
</html>