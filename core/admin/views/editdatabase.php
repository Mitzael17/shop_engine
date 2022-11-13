
        <div class="main-content">
            <div class="edit-container">
                <h1 class="edit-full"><?= empty($data['id']) ? 'New record in database "' . $this->table . '"' : $data['name'] ?></h1>
                <form method="post" <?= empty($data['id']) ? 'data-noasync="true"' : '' ?> enctype="multipart/form-data" accept-charset='utf-8' class="edit-gap edit-block edit-container edit-full" action="<?= PATH . 'admin/' . ( empty($data['id']) ? "add/$this->table" : "edit/$this->table/" . $data['id']) ?>">
                    <div class="edit-block edit-full">
                        <button type="submit" style="margin: 0 .3em 0 0;">Save</button>
                        <?php if (!empty($data['id'])): ?>
                            <a href="<?=PATH . "admin/delete/$this->table/" . $data['id']?>"><button type="button">Delete</button></a>
                        <?php endif; ?>
                    </div>
                    <div class="edit-block edit-block-root edit-half">
                        <?php if(isset($this->templates['left']) && !empty($this->templates['left'])): ?>
                        <?php foreach ($data as $key => $value): ?>

                            <?php
                                if(array_key_exists($key, $this->templates['left'])) {
                                    include 'includes/elements/' . $this->templates['left'][$key] . '.php';
                                }

                            ?>

                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="edit-block edit-block-root edit-half">
                        <?php if(isset($this->templates['right']) && !empty($this->templates['right'])): ?>
                        <?php foreach ($data as $key => $value): ?>

                            <?php
                            if(array_key_exists($key, $this->templates['right'])) {
                                include 'includes/elements/' . $this->templates['right'][$key] . '.php';
                            }

                            ?>

                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php if(isset($this->templates['full']) && !empty($this->templates['full'])): ?>
                    <?php foreach ($data as $key => $value): ?>
                    <?php if(array_key_exists($key, $this->templates['full'])): ?>
                        <div class="edit-block edit-block-root edit-full">

                        <?php include 'includes/elements/' . $this->templates['full'][$key] . '.php'; ?>

                        </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
