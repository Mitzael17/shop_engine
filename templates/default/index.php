

    <main>
        <section id="slider-banner">
            <div class="slider-banner">
                <div class="container">
                    <div class="slider-banner__container">
                        <div class="swiper-wrapper">
                            <?php if (isset($data['rubrics']['main_slider']) && !empty($data['rubrics']['main_slider'])): ?>
                            <?php foreach ($data['rubrics']['main_slider'] as $slide): ?>
                                <div class="slider-banner__slide swiper-slide">
                                <div class="slider-banner__text">
                                    <?= $slide['text']?>
                                </div>
                                <div class="slider-banner__img">
                                    <img src="<?=$this->getImg($slide['img'])?>">
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php if(isset($data['rubrics']['banner_commodities']) && !empty($data['rubrics']['banner_commodities'])): ?>
        <section id="commodities-banner">
            <div class="container">
                <div class="commodities-banner">
                    <?php for ($index = 1; $index <= 3; $index++): ?>

                    <?php if(!isset($data['rubrics']['banner_commodities'][$index-1])) break; ?>

                    <?php if($index !== 2): ?>
                        <div style="background-image: url('<?=PATH . UPLOAD_DIR . $data['rubrics']['banner_commodities'][$index-1]['products']['img']?>');" class="commodities-banner__item commodities-banner__item--<?=$index?>">
                            <a href="<?= PATH . 'product/' . $data['rubrics']['banner_commodities'][$index-1]['products']['alias']?>" class="commodities-banner__title"><?=$data['rubrics']['banner_commodities'][$index-1]['products']['name']?></a>
                            <div class="commodities-banner__discount discount"><span>$<?=$data['rubrics']['banner_commodities'][$index-1]['products']['price']?></span> <?=$data['rubrics']['banner_commodities'][$index-1]['products']['percentage_discount']?>% Off</div>
                            <div class="commodities-banner__price price">$<?=$data['rubrics']['banner_commodities'][$index-1]['products']['price'] - $data['rubrics']['banner_commodities'][$index-1]['products']['discount']?></div>
                        </div>
                    <?php else: ?>
                        <div style="background-image: url('<?=PATH . UPLOAD_DIR . $data['rubrics']['banner_commodities'][$index-1]['products']['img']?>');" class="commodities-banner__item commodities-banner__item--2">
                            <div class="commodities-banner__titlePrice">
                                <a href="<?= PATH . 'product/' . $data['rubrics']['banner_commodities'][$index-1]['products']['alias']?>" class="commodities-banner__title "><?=$data['rubrics']['banner_commodities'][$index-1]['products']['name']?></a>
                                <div class="commodities-banner__price price">$<?=$data['rubrics']['banner_commodities'][$index-1]['products']['price'] - $data['rubrics']['banner_commodities'][$index-1]['products']['discount']?></div>
                            </div>
                            <div class="commodities-banner__discount discount"><span>$<?=$data['rubrics']['banner_commodities'][$index-1]['products']['price']?></span> <?=$data['rubrics']['banner_commodities'][$index-1]['products']['percentage_discount']?>% Off</div>
                        </div>
                    <?php endif; ?>

                    <?php endfor; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <section id="bestSeller">
            <div class="container">
                <div class="bestSeller">
                    <div id="bestSeller__trigger"></div>
                    <h1 class="bestSeller__title">Best seller</h1>
                    <ul class="bestSeller__nav">
                        <li class="bestSeller__item tab-narrow active" data-tab="All">All</li>
                        <li class="bestSeller__item tab-narrow" data-tab="Bags">Bags</li>
                        <li class="bestSeller__item tab-narrow" data-tab="Sneakers">Sneakers</li>
                        <li class="bestSeller__item tab-narrow" data-tab="Belt">Belt</li>
                        <li class="bestSeller__item tab-narrow" data-tab="Sunglasses">Sunglasses</li>
                    </ul>
                    <div class="bestSeller__tabBody">
                        <div class="bestSeller__grid items-list-commodities active" data-tabbody="All">
                            <div class="commodity hot items-list__item">
                                <div class="commodity__img">
                                    <img src="img/imageProduct.png" alt="sneakers">
                                    <div class="commodity__add">
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                                    </div>
                                </div>
                                <div class="commodity__info">
                                    <a href="good.html" class=" commodity__title">Nike Air Max 270 React</a>
                                    <div class="commodity__assessment">
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <div class="commodity__price">
                                        <div class="price">$299,43</div>
                                        <div class="discount"><span>$534.33</span> 24% Off</div>
                                    </div>
                                </div>
                            </div>
                            <div class="commodity items-list__item">
                                <div class="commodity__img">
                                    <img src="img/imageProduct.png" alt="sneakers">
                                    <div class="commodity__add">
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                                    </div>
                                </div>
                                <div class="commodity__info">
                                    <a href="good.html" class=" commodity__title">Nike Air Max 270 React</a>
                                    <div class="commodity__assessment">
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <div class="commodity__price">
                                        <div class="price">$299,43</div>
                                        <div class="discount"><span>$534.33</span> 24% Off</div>
                                    </div>
                                </div>
                            </div>
                            <div class="commodity items-list__item">
                                <div class="commodity__img">
                                    <img src="img/imageProduct.png" alt="sneakers">
                                    <div class="commodity__add">
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                                    </div>
                                </div>
                                <div class="commodity__info">
                                    <a href="good.html" class=" commodity__title">Nike Air Max 270 React</a>
                                    <div class="commodity__assessment">
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <div class="commodity__price">
                                        <div class="price">$299,43</div>
                                        <div class="discount"><span>$534.33</span> 24% Off</div>
                                    </div>
                                </div>
                            </div>
                            <div class="commodity items-list__item">
                                <div class="commodity__img">
                                    <img src="img/imageProduct.png" alt="sneakers">
                                    <div class="commodity__add">
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                                    </div>
                                </div>
                                <div class="commodity__info">
                                    <a href="good.html" class=" commodity__title">Nike Air Max 270 React</a>
                                    <div class="commodity__assessment">
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <div class="commodity__price">
                                        <div class="price">$299,43</div>
                                        <div class="discount"><span>$534.33</span> 24% Off</div>
                                    </div>
                                </div>
                            </div>
                            <div class="commodity items-list__item">
                                <div class="commodity__img">
                                    <img src="img/imageProduct.png" alt="sneakers">
                                    <div class="commodity__add">
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                                    </div>
                                </div>
                                <div class="commodity__info">
                                    <a href="good.html" class=" commodity__title">Nike Air Max 270 React</a>
                                    <div class="commodity__assessment">
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <div class="commodity__price">
                                        <div class="price">$299,43</div>
                                        <div class="discount"><span>$534.33</span> 24% Off</div>
                                    </div>
                                </div>
                            </div>
                            <div class="commodity items-list__item">
                                <div class="commodity__img">
                                    <img src="img/imageProduct.png" alt="sneakers">
                                    <div class="commodity__add">
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                                    </div>
                                </div>
                                <div class="commodity__info">
                                    <a href="good.html" class=" commodity__title">Nike Air Max 270 React</a>
                                    <div class="commodity__assessment">
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <div class="commodity__price">
                                        <div class="price">$299,43</div>
                                        <div class="discount"><span>$534.33</span> 24% Off</div>
                                    </div>
                                </div>
                            </div>
                            <div class="commodity items-list__item">
                                <div class="commodity__img">
                                    <img src="img/imageProduct.png" alt="sneakers">
                                    <div class="commodity__add">
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                                    </div>
                                </div>
                                <div class="commodity__info">
                                    <a href="good.html" class=" commodity__title">Nike Air Max 270 React</a>
                                    <div class="commodity__assessment">
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <div class="commodity__price">
                                        <div class="price">$299,43</div>
                                        <div class="discount"><span>$534.33</span> 24% Off</div>
                                    </div>
                                </div>
                            </div>
                            <div class="commodity items-list__item">
                                <div class="commodity__img">
                                    <img src="img/imageProduct.png" alt="sneakers">
                                    <div class="commodity__add">
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                        <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                                    </div>
                                </div>
                                <div class="commodity__info">
                                    <a href="good.html" class=" commodity__title">Nike Air Max 270 React</a>
                                    <div class="commodity__assessment">
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <div class="commodity__price">
                                        <div class="price">$299,43</div>
                                        <div class="discount"><span>$534.33</span> 24% Off</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bestSeller__more refer-button"><a href="search.html">Load more</a></div>
                </div>
            </div>
        </section>
        <?php if(isset($data['rubrics']['main_banner']) && !empty($data['rubrics']['main_banner'])): ?>
        <section id="main-banner">
            <div class="container">
                <div id="main-banner__trigger"></div>
                <div class="main-banner">
                    <div class="main-banner__info">
                        <div class="main-banner__title"><?=$data['rubrics']['main_banner'][0]['name']?></div>
                        <div class="main-banner__text"><?=$data['rubrics']['main_banner'][0]['text']?></div>
                        <a href="<?=PATH . UPLOAD_DIR . $data['rubrics']['main_banner'][0]['alias']?>" class="main-banner__button refer-button"><?=$data['rubrics']['main_banner'][0]['alias_text']?></a>
                    </div>
                    <div class="main-banner__img"><img src="<?= PATH . UPLOAD_DIR . $data['rubrics']['main_banner'][0]['img']?>" alt="photo"></div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if(isset($data['rubrics']['features']) && !empty($data['rubrics']['features'])): ?>
            <section id="feature">
                <div class="container">
                    <div class="feature">
                        <div id="feature__trigger"></div>
                        <div class="feature__list">
                            <?php foreach ($data['rubrics']['features'] as $feature): ?>
                            <div class="feature__item">
                                <div class="feature__img"><img src="<?=PATH . UPLOAD_DIR . $feature['img']?>" alt="photo"></div>
                                <div class="feature__title"><?=$feature['name']?></div>
                                <div class="feature__text"><?=$feature['text']?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php if(isset($data['rubrics']['news']) && !empty($data['rubrics']['news'])): ?>
            <section id="latest-news">
                <div class="container">
                    <div class="latest-news">
                        <div id="latest-news__trigger"></div>
                        <h1 class="latest-news__title">Latest news</h1>
                        <div class="latest-news__body items-list">
                            <?php foreach ($data['rubrics']['news'] as $news): ?>
                                <div class="latest-news__item items-list__item">
                                    <div class="latest-news__img"><img src="<?=PATH . UPLOAD_DIR . $news['img']?>" alt="<?=$news['name']?>"></div>
                                    <div class="latest-news__info">
                                        <div class="latest-news__date"><?=$news['date']?></div>
                                        <div class="latest-news__subtitle"><?=$news['name']?></div>
                                        <div class="latest-news__text"><?=$news['text']?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php if(isset($data['rubrics']['feature_products']) && !empty($data['rubrics']['feature_products'])): ?>
            <section id="featured-products">
                <div class="container">
                    <div class="featured-products">
                        <div id="featured-products__trigger"></div>
                        <h1 class="featured-products__title">Featured products</h1>
                        <div class="featured-products__body items-list">
                            <?php foreach ($data['rubrics']['feature_products'] as $product): ?>
                            <div class="featured-products__item items-list__item">
                                <div class="featured-products__img"><img src="<?=PATH . UPLOAD_DIR . $product['products']['img']?>" alt="<?=$product['products']['name']?>"></div>
                                <div class="featured-products__info">
                                    <a href="<?=PATH . 'product/' . $product['products']['alias']?>" class="featured-products__subtitle"><?=$product['products']['name']?></a>
                                    <div class="featured-products__assessment commodity__assessment">
                                        <svg class="active"><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#star')?>"></use></svg>
                                        <svg class="active"><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#star')?>"></use></svg>
                                        <svg class="active"><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#star')?>"></use></svg>
                                        <svg class="active"><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#star')?>"></use></svg>
                                        <svg><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#star')?>"></use></svg>
                                    </div>
                                    <div class="discount">
                                        $<?=$product['products']['price'] - $product['products']['discount']?>
                                        <?php if($product['products']['discount'] > 0):?>
                                        <span>$<?=$product['products']['price']?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <section id="search-form">
            <div class="container">
                <div class="form-short search-form">
                    <form action="#" class="form-short__body search-form__body">
                        <input name="search-field" type="text" class="form-short__field search-form__field" placeholder="Search query...">
                        <button class="form-short__button search-form__button">Search</button>
                    </form>
                </div>
            </div>
        </section>
    </main>



