<div class="main-content" style="height: calc(100vh - 5em);">

    <div class="chat">
        <div class="chat__users c-scroll">

            <?php if(!empty($data['users'])): ?>
            <?php foreach ($data['users'] as $user): ?>

                <div data-tab="<?= $user['name']?>" class="chat__user user MiTab-narrow
                <?=
                isset($data['interlocutor']) && !empty($data['interlocutor']) ? ( $data['interlocutor'] === $user['name'] ? 'active' : '') : ''
                ?>
                <?=
                isset($data['unreadMessages'][$user['name']]) ? 'chat__user--unread' : ''
                ?>">
                        <div class="profile-img"><img src="<?=$this->getImg($user['avatar'])?>" alt="logo"></div>
                        <div class="block">
                            <div class="user__name item-text item-header"><?=$user['name']?></div>
                            <div class="user__role item-text item-mini"><?=$user['role']?></div>
                        </div>
                        <div class="chat__numberUnreadMessages"><?= isset($data['unreadMessages'][$user['name']]) ? $data['unreadMessages'][$user['name']] : '0' ?></div>
                </div>


                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="chat__area">

            <?php if(isset($data['interlocutor']) && !empty($data['interlocutor'])):?>

            <div class="MiTab-item active" data-tabbody="<?= $data['interlocutor'] ?>">

                        <div data-date="<?= isset($data['oldestDate']) ? $data['oldestDate'] : '' ?>" class="chat__messages c-scroll">
                            <?php if(isset($data['messages']) && !empty($data['messages'])): ?>
                            <?php foreach ($data['messages'] as $message): ?>
                                <div class="chat__messageText item-text <?=$message['name'] === $_SESSION['admin']['name'] ? 'chat__messageText--right' : 'chat__messageText--left'?>"><?=$message['message']?></div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <form class="chat__form no_default_form" action="#" method="post" name="yourMessage">
                            <div class="chat__inputContainer">
                                <div class="chat__input c-scroll" placeholder="Type something..." tabindex="0" contenteditable="true" name="yourMessage"></div>
                            </div>
                            <button type="submit">Send</button>
                        </form>

            </div>
            <?php endif; ?>


        </div>
    </div>

</div>
<script>
    const CHAT_ASYNC = '<?= $this->protocol . $_SERVER['HTTP_HOST'] . PATH . $this->routes['alias'] . '/chat' ?>';
</script>