
    <script>
        <?php if(isset($_SESSION['answer']) && !empty($_SESSION['answer'])): ?>

            const ANSWER = "<?=$_SESSION['answer'];?>";

            <?php unset($_SESSION['answer']) ?>

        <?php endif; ?>
        const USER = '<?=$_SESSION['admin']['name']?>';
        const SEARCH_URL = '<?= $this->protocol . $_SERVER['HTTP_HOST'] . PATH . $this->routes['alias'] . '/search' ?>';
        const CHAT_SOCKET = '<?= 'ws://' . $_SERVER['HTTP_HOST'] . ':8195' . PATH . $this->routes['alias'] . '/chat/socket' ?>';
    </script>
    <?php $this->getScripts() ?>



</body>
</html>