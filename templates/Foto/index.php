<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Foto $foto
 */

use Authentication\Identity;
use Cake\I18n\FrozenTime;
$time = FrozenTime::now();
?>

<?php
$this->assign('title', __('Foto'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Foto'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);


if (!is_null($foto)) {

    $userLiked = null;
?>
<div class="container">
    <div class="text-right mt-3 mb-3">
        <?= $this->Html->link(__('Tambah Foto Baru'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="row">
        <?php foreach ($foto as $fotoItem) : ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?= $this->Html->image('img/'.$fotoItem->lokasi_foto, ['class' => 'card-img-top img-thumbnail', 'alt' => $fotoItem->judul_foto]) ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= h($fotoItem->judul_foto) ?></h5>
                        <p class="card-text"><?= h($fotoItem->deskripsi) ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><?= __('Tanggal Unggahan: ') . h($fotoItem->tgl_unggahan->format('d-m-Y H:i:s')) ?></li>
                        <li class="list-group-item"><?= __('Album: ') ?></li>
                        <li class="list-group-item pl-4"><?= ($fotoItem->has('album') ? $this->Html->link($fotoItem->album->nama_album, ['controller' => 'Album', 'action' => 'view', $fotoItem->album->id]) : '') ?></li>
                        <li class="list-group-item"><?= __('User: ') ?></li>
                        <li class="list-group-item pl-4"><?= ($fotoItem->has('user') ? $this->Html->link($fotoItem->user->username, ['controller' => 'User', 'action' => 'view', $fotoItem->user->id]) : '') ?></li>
                    </ul>
                    <div class="card-footer">
                        <div class="ml-auto">
                        <?php 
                    // Inisialisasi variabel $userLiked menjadi false
                    $userLiked = false;
                    $likeId = null;

                    // Periksa apakah pengguna telah menyukai foto
                    if (!empty($fotoItem->likefoto) && is_iterable($fotoItem->likefoto)) {
                        foreach ($fotoItem->likefoto as $likefoto) {
                            if ($likefoto->user_id === $this->request->getAttribute('identity')->get('id')) {
                                $userLiked = true; // Jika pengguna telah menyukai foto, set variabel $userLiked menjadi true
                                $likeId = $likefoto->id; // Simpan ID likefoto
                                break;
                            }
                        }
                    }
                    ?>
                    <td>
                    <?php if ($userLiked): ?>
                        <?= $this->Form->postLink(__('🖤'), ['controller'=>'Likefoto', 'action' =>'delete', $likeId], ['confirm' => __('Are you sure you want to unlike this photo?'), 'class' => 'btn btn-danger', 'id' => 'likeButton_'.$fotoItem->id]) ?>
                    <?php else: ?>
                        <?= $this->Form->create(null, ['url' => ['controller'=>'Likefoto', 'action' =>'add'],'role'=>'form']) ?>
                            <div class="ml-auto">
                                <?= $this->Form->button(__('❤️'), ['class' => 'btn btn-primary', 'onclick' => 'toggleLikeButton("likeButton_'.$fotoItem->id.'")', 'id' => 'likeButton_'.$fotoItem->id]) ?>
                                <?= $this->Form->control('foto_id', ['type' => 'hidden','value' => $fotoItem->id, 'class' => 'form-control']) ?>
                                <?= $this->Form->control('user_id', ['value' => $this->request->getAttribute('identity')->get('id'), 'class' => 'form-control','type' => 'hidden']) ?>
                                <?= $this->Form->control('tgl_like',['value' => $time->i18nFormat('yyyy-MM-dd HH:mm:ss'), 'type' => 'hidden']) ?>
                            </div>
                        <?= $this->Form->end() ?>
                    <?php endif; ?>
                    <br>
                    </td>
                        </div>
                        <?= $this->Html->link(__('View'), ['action' => 'view', $fotoItem->id], ['class' => 'btn btn-primary']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $fotoItem->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $fotoItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fotoItem->id), 'class' => 'btn btn-danger']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
}
?>