
    <main>
        <div class="container">
            <div class="good-page">
                <div class="good">
                    <div class="good__preview">
                        <div class="good__carusel carusel">
                            <?php if(!empty($data['product']['slider_img'])): ?>

                                <div class="carusel__mainImgContainer"><img class="carusel__mainImg" src="<?=$this->getImg($data['product']['slider_img'][0])?>" alt="photo"></div>

                                <div class="carusel__otherImg">
                                <?php foreach ($data['product']['slider_img'] as $key => $img): ?>

                                    <div class="carusel__imgContainer"><img class="carusel__img <?= $key === 0 ? 'active' : '' ?>" src="<?=$this->getImg($img)?>" alt="photo"></div>

                                <?php endforeach; ?>
                                </div>

                            <?php else: ?>
                                <div class="carusel__mainImgContainer"><img class="carusel__mainImg" src="<?=$this->getImg($data['product']['img'])?>" alt="photo"></div>
                                <div class="carusel__otherImg">
                                    <div class="carusel__imgContainer"><img class="carusel__img active" src="<?=$this->getImg($data['product']['img'])?>" alt="photo"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="good__mobileSlider good-mslider">
                            <div class="swiper-wrapper">

                                <?php if(!empty($data['product']['slider_img'])): ?>
                                <?php foreach ($data['product']['slider_img'] as $img): ?>
                                        <div class="swiper-slide"><img class="swiper-lazy" data-srcset="<?=$this->getImg($img)?>" src="<?=$this->getImg('mainImg/loading.gif')?>" alt="photo"></div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="swiper-slide"><img class="swiper-lazy" data-srcset="<?=$this->getImg($data['product']['img'])?>" src="<?=$this->getImg($data['product']['img'])?>" alt="photo"></div>
                                <?php endif; ?>
                            </div>
                            <div class="good-mslider__pagination slider-pagination"></div>
                        </div>
                        <div class="good__info">
                            <div class="commodity__title commodity__title--2"><?=$data['product']['name']?></div>
                            <div class="commodity__assessment stick commodity__assessment--2">
                                <?php for ($index=1; $index < 6 ;$index++): ?>
                                    <svg class="<?= $data['product']['data_reviews']['rating'] < $index ? '' : 'active' ?>"><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#star')?>"></use></svg>
                                <?php endfor; ?>
                                <div class="commodity__reviews--2"><?=$data['product']['data_reviews']['quantity']?> reviews</div>
                                <a href='#' class="commodity__submitReview--2">Submit a review</a>
                            </div>
                            <div class="commodity__price commodity__price--2">
                                <div class="price price--2">$<?= $data['product']['discount'] > 0 ? $data['product']['price'] - $data['product']['discount'] : $data['product']['price'] ?></div>
                                <?php if($data['product']['discount'] > 0): ?>
                                <div class="discount discount--2"><span>$<?=$data['product']['price']?></span> <?=$data['product']['percentage_discount']?>% Off</div>
                                <?php endif; ?>
                            </div>
                            <div class="good__status stick">
                                <div class="good__statusItem">Availability:</div>
                                <div class="good__statusItem"><?=$data['product']['quantity'] > 0 ? 'In stock' : 'Out stock'?></div>
                                <div class="good__statusItem">Category:</div>
                                <div class="good__statusItem"><?=$data['product']['category']?></div>
                                <div class="good__statusItem">Free shipping</div>
                            </div>
                            <div class="good__form">
                                <form action="#">
                                    <div class="good__parametrs">
                                        <div class="stick">
                                            <?php if(isset($data['product']['filters'])): ?>
                                                <?php foreach ($data['product']['filters'] as $key => $value): ?>
                                                    <?php include 'includes/components/product/' . $value['type'] . '.php'  ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="good__block stick">
                                            <div class="good__quantityGoods counter">
                                                <button class="counter-minus" type="button" onclick="this.nextElementSibling.stepDown();">-</button>
                                                <input type="number" value="1" name="good__counter" readonly value="1" min="1" max="99">
                                                <button class="counter-plus" type="button" onclick="this.previousElementSibling.stepUp();">+</button>
                                            </div>
                                            <div class="commodity__add2">
                                                <div class="commodity__icon commodity__icon--2"><svg><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#favorite')?>"></use></svg></div>
                                                <div class="commodity__icon commodity__icon--2"><svg><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#trolley')?>"></use></svg></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="good__socials">
                                    <button class="share share-facebook">
                                        <svg><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#facebook')?>"></use></svg>
                                        Share on Facebook
                                    </button>
                                    <button class="share share-twitter">
                                        <svg><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#twitter')?>"></use></svg>
                                        Share on Twitter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="good__tabs">
                        <ul class="good__nav">
                            <li class="good__navItem stick-focus tab-narrow active active-stick" data-tab="Product_information">Product Information</li>
                            <li class="good__navItem stick-focus tab-narrow" data-tab="Reviews">Reviews 2</li>
                            <li class="good__navItem stick-focus tab-narrow" data-tab="submitReview">Submit review</li>
                            <div class="stick-follow"><span></span></div>
                        </ul>
                        <div class="good__tabBody">
                            <div class="good__tabBodyItem active" data-tabbody="Product_information">
                                <div class="light-text">
                                    <?=$data['product']['content']?>
                                </div>
                            </div>
                            <div class="good__tabBodyItem" data-tabbody="Reviews">
                                <div class="review">
                                    <div class="review__header">
                                        <img src="../../../../../работы/другое/E-Comm/dist/img/customer.png" alt="customer">
                                        <div class="review__block">
                                            <div class="review__name">James Lawson</div>
                                            <div class="review__assessment commodity__assessment">
                                                <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                                <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                                <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                                <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                                <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="light-text">air max are always very comfortable fit, clean and just perfect in every way. just the box was too small and scrunched the sneakers up a little bit, not sure if the box was always this small but the 90s are and will always be one of my favorites.</p>
                                    <div class="review__img">
                                        <img class="review__customerImg" src="../../../../../работы/другое/E-Comm/dist/img/imageProduct.png" alt="photo">
                                        <img class="review__customerImg" src="../../../../../работы/другое/E-Comm/dist/img/discount--1.png" alt="photo">
                                        <img class="review__customerImg" src="../../../../../работы/другое/E-Comm/dist/img/discount--2.png" alt="photo">
                                    </div>
                                    <div class="review__date">December 10, 2016</div>
                                </div>
                                <div class="review">
                                    <div class="review__header">
                                        <img src="../../../../../работы/другое/E-Comm/dist/img/customer.png" alt="customer">
                                        <div class="review__block">
                                            <div class="review__name">James Lawson</div>
                                            <div class="review__assessment commodity__assessment">
                                                <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                                <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                                <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                                <svg class="active"><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                                <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="light-text">air max are always very comfortable fit, clean and just perfect in every way. just the box was too small and scrunched the sneakers up a little bit, not sure if the box was always this small but the 90s are and will always be one of my favorites.</p>
                                    <div class="review__img">
                                        <img class="review__customerImg" src="../../../../../работы/другое/E-Comm/dist/img/imageProduct.png" alt="photo">
                                        <img class="review__customerImg" src="../../../../../работы/другое/E-Comm/dist/img/discount--1.png" alt="photo">
                                        <img class="review__customerImg" src="../../../../../работы/другое/E-Comm/dist/img/discount--2.png" alt="photo">
                                    </div>
                                    <div class="review__date">December 10, 2016</div>
                                </div>
                            </div>
                            <div class="good__tabBodyItem" data-tabbody="submitReview">
                                <form name="review" action="#">
                                    <h2>Your review</h2>
                                    <textarea class="field field-area" name="text" id="" minlength="10" maxlength="250" placeholder="Write your review"></textarea>
                                    <div class="review__assessment commodity__assessment">
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                        <svg><use xlink:href="img/icons/icons.svg#star"></use></svg>
                                    </div>
                                    <input type="hidden" value="5">
                                    <div class="error-gallery-message">Недопустимый тип файла</div>
                                    <div class="review-gallery">
                                        <div class="photo-container">
                                            <label for="images">
                                                <input id="images" name="im" type="file" multiple accept="image/*">
                                                <div id="#addPhoto" class="icon-plus"><span></span><span></span></div>
                                            </label>
                                        </div>

                                    </div>
                                    <button class="button">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <aside class="good-aside">
                    <?php if(isset($data['bestSellerSlider'])): ?>
                        <div class="good-aside__title">best seller</div>
                        <div class="good-aside__slider">
                            <div class="swiper-wrapper">
                                <?php foreach ($data['bestSellerSlider'] as $product): ?>
                                <div class="commodity swiper-slide">
                                    <div class="commodity__img">
                                        <img class="swiper-lazy" data-srcset="<?=$this->getImg($product['img'])?>" src="<?=$this->getImg('mainImg/loading.gif')?>">
                                        <div class="commodity__add">
                                            <div class="commodity__icon"><svg><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#favorite')?>"></use></svg></div>
                                            <div class="commodity__icon"><svg><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#trolley')?>"></use></svg></div>
                                        </div>
                                    </div>
                                    <div class="commodity__info">
                                        <a href="<?= PATH. 'product/' . $product['alias'] ?>" class=" commodity__title"><?=$product['name']?></a>
                                        <div class="commodity__assessment commodity__assessment--2">
                                            <?php for($index = 1; $index <= 5; $index++): ?>
                                                <svg class="<?= $product['rating'] >= $index ? 'active' : '' ?>"><use xlink:href="<?=$this->getImg('mainImg/icons/icons.svg#star')?>"></use></svg>
                                            <?php endfor;?>
                                        </div>
                                        <div class="commodity__price">
                                            <?php if($product['discount'] > 0): ?>
                                                <div class="discount">$<?=$product['price'] - $product['discount']?> <span>$<?=$product['price']?></span></div>
                                            <?php else: ?>
                                                <div class="price">$<?=$product['price']?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="good-aside__pagination slider-pagination"></div>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>
            <div class="relatedProducts">
                <h1 class="relatedProducts__title">related Products</h1>
                <div class="relatedProducts__list items-list-commodities">
                    <div class="commodity hot items-list__item">
                        <div class="commodity__img">
                            <img src="../../../../../работы/другое/E-Comm/dist/img/imageProduct.png" alt="sneakers">
                            <div class="commodity__add">
                                <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#favorite"></use></svg></div>
                                <div class="commodity__icon"><svg><use xlink:href="img/icons/icons.svg#trolley"></use></svg></div>
                            </div>
                        </div>
                        <div class="commodity__info">
                            <a href="good.html" class="commodity__title">Nike Air Max 270 React</a>
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
                            <img src="../../../../../работы/другое/E-Comm/dist/img/discount--3.png" alt="sneakers">
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
                            <img src="../../../../../работы/другое/E-Comm/dist/img/discount--2.png" alt="sneakers">
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
                            <img src="../../../../../работы/другое/E-Comm/dist/img/imageProduct.png" alt="sneakers">
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
        </div>
    </main>

    <script>
        const REVIEW_SUBMIT_URL = "<?= PATH . 'product/review' ?>";
    </script>
