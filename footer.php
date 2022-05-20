<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
		<?php if ($this->user->hasLogin()) { ?>
			<?php if ($this->is('single')) { ?>
			<a href="<?php $this->options->adminUrl(); ?>write-<?php echo $this->is('post')?'post':'page'; ?>.php?cid=<?php echo $this->cid;?>">
				<button id="adminbtn" class="btn btn-icon-only rounded-circle btn-primary admin-btn">
					<span class="btn-inner--icon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
				</button>
			</a>
			<?php } else { ?>
			<a href="<?php $this->options->adminUrl(); ?>">
				<button id="adminbtn" class="btn btn-icon-only rounded-circle btn-primary admin-btn">
					<span class="btn-inner--icon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
				</button>
			</a>
			<?php } ?>
		<?php } ?>
	</main>

	<!-- Footer -->
	<footer class="footer">
		<div class="container">
			<?php if ($this->options->footerWidget) { ?>
			<div class="row">
				<div class="col-md-4 widget">
					<h5>最新评论</h5>
					<?php $comments_recent = $this->widget('Widget_Comments_Recent', 'pageSize=5');
						if ($comments_recent->have())
						{
							_e('<ul>');
							while($comments_recent->next())
							{
								_e('<li><a href="' . "$comments_recent->permalink" . '" class="footer-link">' . "$comments_recent->author" . ': ');
								$comments_recent->excerpt(35, '...');
								_e('</a></li>');
							}
							_e('</ul>');
						}
						else
						{
							_e('暂无评论');
						}
					?>
				</div>
				<div class="col-md-4 widget">
					<h5>最新文章</h5>
					<ul><?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=6')->parse('<li><a href="{permalink}" class="footer-link">{title}</a></li>'); ?></ul>
				</div>
				<div class="col-md-4 widget">
					<h5>近期归档</h5>
					<ul><?php $this->widget('Widget_Contents_Post_Date', 'limit=6&type=month&format=F Y')->parse('<li><a href="{permalink}" class="footer-link">{date}</a></li>'); ?></ul>
				</div>
			</div>
			<hr/>
			<?php } ?>
			<div class="row">
				<div class="col-md-6">
					<div class="copyright">
						<?php _e($this->options->footerText); ?>
					</div>
				</div>
				<div class="col-md-6">
					<ul class="nav nav-footer justify-content-end">
						<li class="nav-item">
							<a class="nav-link" href="<?php $this->options->siteUrl(); ?>">首页</a>
						</li>
						<?php $this->widget('Widget_Contents_Page_List')->to($pages);
							while($pages->next()): ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
							</li>
						<?php endwhile; ?>
						<?php if($this->user->hasLogin()): ?>
							<li class="nav-item"><a class="nav-link" href="<?php $this->options->adminUrl(); ?>">进入后台(<?php $this->user->screenName(); ?>)</a></li>
							<li class="nav-item"><a class="nav-link" href="<?php $this->options->logoutUrl(); ?>">退出</a></li>
						<?php else: ?>
							<li class="nav-item"><a class="nav-link" href="<?php $this->options->adminUrl('login.php'); ?>">登录</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<?php if($this->options->Pjax) _e('</div>'); ?>
	<a id="scrollup" href="#" style="display: none;">
		<button id="scrollbtn" class="btn btn-icon-only rounded-circle btn-secondary scrollup-btn">
			<span class="btn-inner--icon"><i class="fa fa-arrow-up" aria-hidden="true"></i></span>
		</button>
	</a>
	<!-- Core -->
	<script src="https://cdn.staticfile.org/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://cdn.staticfile.org/bootstrap/4.5.3/js/bootstrap.min.js"></script>
	<!-- Optional plugins -->
	<script src="https://cdn.bootcdn.net/ajax/libs/headroom/0.11.0/headroom.min.js"></script>
	<!-- Theme JS -->
	<script src="<?php $this->options->themeUrl("assets/js/argon.min.js"); ?>"></script>
	<script src="<?php $this->options->themeUrl("assets/js/bbrender.js"); ?>"></script>
	<!-- scrollup -->
	<script>
		$(function(){
			var scrollBottom = parseInt($("#adminbtn").css("bottom")) + parseInt($("#adminbtn").css("height")) + 25;
			$("#scrollbtn").css("bottom", scrollBottom);
			var resizeTimer;
			$(window).resize(function(e) {
				if ($("#adminbtn").length > 0)
				{
					clearTimeout(resizeTimer);
					resizeTimer = setTimeout(function() {
						scrollBottom = parseInt($("#adminbtn").css("bottom")) + parseInt($("#adminbtn").css("height")) + 25;
						$("#scrollbtn").css("bottom", scrollBottom);
					}, 250);
				}
			});
			var scrollLock = 0;
			if ($(window).scrollTop() > 500) $("#scrollup").fadeIn(400);
			$(window).scroll(function() {
				if (!scrollLock)
				{
					if ($(window).scrollTop() > 500) $("#scrollup").fadeIn(400);
					else $("#scrollup").fadeOut(400);
				}
			});
			$("#scrollup").click(function() {
				scrollLock = 1;
				$("#scrollup").fadeOut(400);
				$("html,body").animate({scrollTop: "0px"}, 500, function() {
					scrollLock = 0;
				});
			});
		});
	</script>
	<!-- Pjax -->
	
	<script>
		function init(){
			<?php if($this->options->prismjs and $this->options->prismLine): ?>
			var pres = document.querySelectorAll('pre');
			var lineNumberClassName = 'line-numbers';
			pres.forEach(function (item, index) {
				item.className = item.className == '' ? lineNumberClassName : item.className + ' ' + lineNumberClassName;
			});
			Prism.highlightAll(false,null);
			<?php endif; ?>
			$("img").Lazy({
                threshold: 700,
                effect: 'fadeIn',
                effectTime: 1000,
                defaultImage: "<?php $this->options->themeUrl("images/Loading.gif"); ?>"
            });
            $("div[data-src]").Lazy({
                threshold: 700,
                effect: 'fadeIn',
                placeholder: "<?php $this->options->themeUrl("images/Loading.gif"); ?>",
                effectTime: 1000
            });
			<?php if($this->options->katex): ?>
			try{
				renderMathInElement(document.body,{
					delimiters: [
						{left: "$$", right: "$$", display: true},
						{left: "$", right: "$", display: false}
					]
				})
			}catch(e){}
			<?php endif; ?>

			parseBbcode()
			parseBblink()

			<?php if($this->options->Pjax): ?>
      ;<?php $this->options->pjaxcomp() ?>;

			try{
				window.onload()
			}catch(e){}
			<?php endif; ?>
			<?php if ($this->options->viewerEnable): ?>
			setTimeout(() => {
				$('.content').viewer({
					url: 'data-src'
				})
			},300)
			<?php endif; ?>
		}

			<?php if ($this->options->viewerEnable): ?>
		function destroy(){
			// viewerjs
			var viewer = $('.content').data('viewer');
			if(viewer){
				viewer.destroy()
			}
		}
		window.addEventListener("popstate", function(e) {
			setTimeout(() => {
				$('.content').viewer({
					url: 'data-src'
				})
			},300)
		}, false);
			<?php endif; ?>
	</script>
	<?php if($this->options->Pjax): ?>
	<script src="https://cdn.staticfile.org/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
	<script src="<?php $this->options->themeUrl("assets/js/progress.js"); ?>"></script>
	<script>
		var pgid = 0
		$(document).pjax('a[href^="<?php Helper::options()->siteUrl()?>"]:not(a[target="_blank"], a[no-pjax], a[href^="<?php Helper::options()->siteUrl()?>/admin"])',
		{
    		container: '#pjax-container',
    		fragment: '#pjax-container',
    		timeout: 8000
		}).on('pjax:send', function() {
			pgid = start_progress()
			$(".black-cover").fadeIn(400)
			$('html,body').animate({ scrollTop: $('html').offset().top}, 500)

			<?php if ($this->options->viewerEnable): ?>
			destroy()
			<?php endif; ?>

		}).on('pjax:complete', function() {
			$(".black-cover").fadeOut(400)
			stop_progress(pgid)
			init()
			
		})
		$("#search").submit(function() {
			var att = $(this).serializeArray()
			for(var i in att){
				if(att[i].name=="s"){
					$.pjax({url: <?php if ($this->options->rewrite): ?>"<?php $this->options->siteUrl(); ?>search/"+att[i].value+"/"<?php else: ?>"<?php $this->options->siteUrl(); ?>index.php/search/"+att[i].value+"/"<?php endif; ?>, container: '#pjax-container',fragment: '#pjax-container',timeout:8000})
				}
			}
			return false
		})
	</script>
	<div class="black-cover" style="display: none;"></div>
	<?php endif; ?>
	<!-- KaTeX JS -->
	<?php if($this->options->katex): ?>
	<script src="https://cdn.staticfile.org/KaTeX/0.10.1/katex.min.js"></script>
	<script src="https://cdn.staticfile.org/KaTeX/0.11.1/dist/contrib/auto-render.min.js"></script>
	<?php endif; ?>
	<!-- Prism JS -->
	<?php if($this->options->prismjs): ?>
	<script src="https://cdn.staticfile.org/prism/1.20.0/components/prism-core.min.js"></script>
	<script src="https://cdn.staticfile.org/prism/1.20.0/plugins/autoloader/prism-autoloader.min.js"></script>
	<script src="https://cdn.staticfile.org/prism/1.20.0/plugins/toolbar/prism-toolbar.min.js"></script>
	<script src="https://cdn.staticfile.org/prism/1.20.0/plugins/show-language/prism-show-language.min.js"></script>
	<script src="https://cdn.staticfile.org/prism/1.20.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
	<?php if($this->options->prismLine): ?>
		<script src="https://cdn.staticfile.org/prism/1.20.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
	<?php endif; ?>
	<?php endif; ?>
	<!-- Alert -->
	<div id="modal-notification" class="modal fade show" id="modal-notification" style="z-index: 102;display: none;">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 id="msgMain" class="modal-title" id="mySmallModalLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#modal-notification').hide('normal');">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div id="msgDetail" class="modal-body"></div>
			</div>
		</div>
	</div>
	<script>
		function alert(main,detail){
			$("#msgMain").html(main)
			if(detail) $("#msgDetail").html(detail)
			else $("#msgDetail").html("")
			$("#modal-notification").show("normal");
		}
		init()
	</script>
	<!-- Typecho footer -->
	<?php $this->footer(); ?>
	</body>
</html>
