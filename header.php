<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
  if ($this->is('single')) {
    if ($this->options->toc) {
      $this->content = createCatalog($this->content);
    }
    $this->content = preg_replace('/<img(.*?)src=[\'"]([^\'"]+)[\'"](.*?)>/i',"<noscript>\$0</noscript><img\$1data-src=\"\$2\" \$3>",$this->content);
  }
  ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title><?php $this->archiveTitle(array(
			'category'  =>  _t('%s 下的文章'),
			'search'    =>  _t('包含关键字 %s 的文章'),
			'tag'       =>  _t('标签 %s 下的文章'),
			'author'    =>  _t('%s 的文章')
		), '', ' - '); ?><?php
		$this->options->title();
		if ($this->is('index') && $this->options->subtitle != '') echo " - {$this->options->subtitle}";
	?></title>

	<!-- Favicon -->
	<link href="<?php
		if ($this->options->logoUrl == '') {
			$this->options->themeUrl("images/logo.png");
		} else {
			$this->options->logoUrl();
		}
	?>" rel="icon" type="image/png">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

	<!-- FontAwesome -->
	<link href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<!-- Main CSS -->
	<link type="text/css" href="<?php $this->options->themeUrl("assets/css/main.min.css"); ?>" rel="stylesheet">

	<!-- KaTeX CSS -->
	<?php if ($this->options->katex): ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/KaTeX/0.11.1/katex.min.css">
	<?php endif; ?>

	<!-- PrismJS CSS -->
	<?php if ($this->options->prismjs): ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/prism/1.20.0/themes/<?php $this->options->prismTheme(); ?>.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/prism/1.20.0/plugins/toolbar/prism-toolbar.css" />
		<?php if ($this->options->prismLine): ?>
		<link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/prism/1.20.0/plugins/line-numbers/prism-line-numbers.css" />
		<?php endif; ?>
	<?php endif; ?>

	<!-- Viewer CSS -->
	<?php if ($this->options->viewerEnable): ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/viewerjs/1.10.5/viewer.min.css" />
	<?php endif; ?>

	<!-- Jquery -->
	<script src="https://cdn.staticfile.org/jquery/3.4.1/jquery.min.js"></script>

	<!-- Custom CSS -->
	<?php if ($this->options->customCss): ?>
	<style type="text/css"><?php $this->options->customCss(); ?></style>
	<?php endif; ?>

	<!-- Viewer.js Plugin -->
	<?php if ($this->options->viewerEnable): ?>
	<script src="https://cdn.staticfile.org/viewerjs/1.10.5/viewer.min.js"></script>
	<!-- TODO -->
	<script src="https://www.unpkg.com/jquery-viewer@1.0.1/dist/jquery-viewer.min.js"></script>
	<?php endif; ?>

	<!-- MD5 Js -->
	<script src="<?php $this->options->themeUrl("assets/js/md5.min.js"); ?>"></script>
	<!-- LazyLoad Js -->
	<script type="text/javascript" src="https://cdn.staticfile.org/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="https://cdn.staticfile.org/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
	<!-- Typecho header -->
	<?php if($this->options->Pjax=="1"): ?>
		<?php $this->header('commentReply=&antiSpam='); ?>
	<?php else: ?>
		<?php $this->header('commentReply='); ?>
	<?php endif; ?>
</head>
<body>
	<header class="header-global">
		<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
			<div class="container">
				<a class="navbar-brand" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbar-default">
					<div class="navbar-collapse-header">
						<div class="row">
							<div class="col-6 collapse-brand">
								<a href="<?php $this->options->siteUrl(); ?>"><h5><?php $this->options->title() ?></h5></a>
							</div>
							<div class="col-6 collapse-close">
								<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
									<span></span>
									<span></span>
								</button>
							</div>
						</div>
					</div>
					<ul class="navbar-nav ml-lg-auto align-items-lg-center">
						<li class="nav-item">
							<a class="nav-link" href="<?php $this->options->siteUrl(); ?>">首页</a>
						</li>
						<li class="nav-item">
						<?php
							$this->widget('Widget_Contents_Page_List')->to($pages);
							while($pages->next()):
						?>
							<li class="nav-item">
								<a class="nav-link" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
							</li>
						<?php endwhile; ?>
						<?php
							$links = explode("$@!$", $this->options->headerLinks);
							foreach ($links as $key => $value) {
								$link = explode("$$", $value)
						?>
							<li class="nav-item">
								<a class="nav-link" target="_blank" href="<?php echo $link[1]; ?>" title="<?php echo $link[0]; ?>"><?php echo $link[0]; ?></a>
							</li>
						<?php }; ?>
						<li class="navbar_search_container">
							<form method="post" action="" id="search">
								<div class="input-group input-group-alternative">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fa fa-search"></i></span>
									</div>
									<input type="text" name="s" class="form-control" placeholder="搜点什么……" type="text" autocomplete="off">
								</div>
							</form>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<?php if($this->options->Pjax) _e('<div id="pjax-container">'); ?>
