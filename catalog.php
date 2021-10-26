<?php
/**
 * 分类目录页面模板
 *
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

        <main>
                <section class="section section-lg section-hero section-shaped">
                        <!-- Background circles -->
                        <?php printBackground(getRandomImage($this->options->randomImage), $this->options->bubbleShow); ?>
                        <div class="container shape-container d-flex align-items-center py-lg">
                                <div class="col px-0 text-center">
                                        <div class="row align-items-center justify-content-center">
                                                <h1 class="text-white"><?php $this->title() ?></h1>
					</div>
					<h5 class="text-white" style="display: block;">
                                                <?php echo ViewsCounter_Plugin::getViews(); ?> 次浏览
                                        </h5>
                                </div>
                        </div>
                </section>
                <section class="section section-components bg-secondary content-card-container">
                        <div class="container container-lg py-5 align-items-center content-card-container">
                                <div class="card shadow content-card content-card-head">
                                        <!-- Page content -->
                                        <section class="section">
                                                <div class="container">
                                                        <div class="content">
								<!-- -->
<?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
                    <?php while($categorys->next()): ?>
                        <?php if ($categorys->levels === 0): ?>
                            <?php $children = $categorys->getAllChildren($categorys->mid); ?>
                            <?php if (empty($children)) { ?>
                                <li style="list-style: none; font-size: 1.6rem;" <?php if($this->is('category', $categorys->slug)): ?> class="active"<?php endif; ?>>
                                    <a style="display: inline-block; padding: 0.2rem 0; " href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?></a>
                                </li>
                            <?php } else { ?>
                                <li style="list-style: none;">
				    <a style="display: inline-block; padding: 0.2rem 0; font-size: 1.6rem" href="<?php $categorys->permalink(); ?>" data-target="#"><?php $categorys->name(); ?></a>
                                    <ul class="png" style="list-style: none;">
                                        <?php foreach ($children as $mid) { ?>
                                            <?php $child = $categorys->getCategory($mid); ?>
                                            <li <?php if($this->is('category', $mid)): ?> class="active"<?php endif; ?>>
                                                <a style="font-size: 1.4rem" href="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
								<!-- -->
                                                        </div>
                                                </div>
                                        </section>
                                </div>
                                <!-- Comment -->
                                <?php if (!$this->hidden && $this->allow('comment')): ?>
                                <div class="card shadow content-card">
                                        <?php $this->need('comments.php'); ?>
                                </div>
                                <?php endif; ?>
                        </div>
                </section>
<?php $this->need('footer.php'); ?>
</div>
