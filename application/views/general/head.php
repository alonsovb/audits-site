<!DOCTYPE html>
<html>
<head>
	<title><?php if (isset($title)) echo $title; else echo 'Audits'; ?></title>
	<meta charset='utf-8' />
	<meta name="viewport" content="width=device-width" />
	<link rel="icon" type="image/png" href=<?php echo '"'.base_url('assets/images/icons/favicon.png').'"' ?> />
	<?php if (isset($css)) {
		if (is_array($css)) {
			foreach ($css as $item):
				echo link_tag(base_url('assets/css/'.$item.'.css'));
			endforeach;
		} else if (is_string($css)) {
			echo link_tag(base_url('assets/css/'.$css.'.css'));
		}
	}
	if (isset($js)) {
		if(is_array($js)) {
			foreach ($js as $item): ?>
				<script type="text/javascript" src=<?php echo '"'.base_url('assets/js/'.$item.'.js').'"'; ?>></script>
			<?php endforeach;
		} else if (is_string($js)) { ?>
			<script type="text/javascript" src=<?php echo '"'.base_url('assets/js/'.$js.'.js').'"'; ?>></script>
		<?php }
	}
	?>

</head>
<body>
