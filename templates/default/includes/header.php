<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <link rel="icon" sizes="32x32" href="img/logo.svg">
    <?php $this->getStyles() ?>

    <title><?=$this->titlePage?></title>
</head>


<body class="notranslate">


<header>
    <section id="header-information">
        <div class="container">
            <div class="header">
                <div class="header__interface interface">
                    <a class="interface__profile" href="profile.html">
                        <img class="interface__iconUser" src="<?=$this->getImg('mainImg/profile-icon.svg');?>" alt="userIcon">
                        <span>My profile</span>
                    </a>
                    <div class="interface__trolley">
                        <a href="basket.html"><img src="<?=$this->getImg('mainImg/trolley.svg');?>" alt="trolley"></a>
                        <div class="interface__quantityGoods">2</div>
                    </div>
                    <div class="interface__summary summary">
                        <div class="summary__item">Items</div>
                        <div class="summary__price">$0.00</div>
                    </div>
                    <div class="interface__search pointer">
                        <img id="search-field-icon" src="<?=$this->getImg('mainImg/search.svg')?>" alt="search">
                        <div class="header-search-field-container">
                            <input type="text">
                            <div class="hints-wrapper">
                                <div class="hints"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="headerMenu">
                <div class="headerMenu__logo"><a href="<?=PATH?>"><img src="<?=$this->getImg('mainImg/logo.png');?>" alt="logo"></a></div>
                <div class="headerMenu__nav nav">
                    <nav>
                        <ul class="nav__list">
                            <li class="nav__item MiDropList-refer active">
                                <a href="#">Home</a>
                                <div class="nav__nestedList nestedList">
                                    <ul class="nestedList__container">
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Home</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Category</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Category</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav__item MiDropList-refer">
                                <a href="#">Bags</a>
                                <div class="nav__nestedList nestedList">
                                    <ul class="nestedList__container">
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">bags</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">CdfgdfgdfgShoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Category</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Bags</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav__item MiDropList-refer">
                                <a href="#">Sneakers</a>
                                <div class="nav__nestedList nestedList">
                                    <ul class="nestedList__container">
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Sneakers</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Category</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Category</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav__item MiDropList-refer">
                                <a href="#">Belt</a>
                                <div class="nav__nestedList nestedList">
                                    <ul class="nestedList__container">
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Belt</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Category</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nestedList__list">
                                            <div class="nestedList__titleCategory">Category</div>
                                            <div class="nestedList__items">
                                                <div class="nestedList__block">
                                                    <a href="#" class="nestedList__item">Coporate Shoes</a>
                                                    <a href="#" class="nestedList__item">Sneakers</a>
                                                    <a href="#" class="nestedList__item">Sandals</a>
                                                    <a href="#" class="nestedList__item">Sport Shoe</a>
                                                    <a href="#"class="nestedList__item">Trainers</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav__item"><a href="contact.html">contact</a></li>
                        </ul>
                    </nav>
                    <div class="headerMenu__cross"><span></span></div>
                </div>
                <div class="headerMenu__burger"><span></span></div>
            </div>
        </div>
    </section>
    <section class="headerUrl">
        <div class="container">
            <div class="headerUrl">

            </div>
        </div>
    </section>
</header>