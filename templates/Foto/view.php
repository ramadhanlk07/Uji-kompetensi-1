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

$likecount = count($foto->likefoto);
$userLiked = null;
foreach ($foto->likefoto as $likefoto) {
    if ($likefoto->user_id === $this->Identity->get('id')) {
        $userLiked = $likefoto;
        break;
    }
}
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title"><?= h($foto->judul_foto) ?></h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Judul Foto') ?></th>
                <td><?= h($foto->judul_foto) ?></td>
            </tr>
            <tr>
                <th><?= __('Deskripsi') ?></th>
                <td><?= h($foto->deskripsi) ?></td>
            </tr>
            <tr>
                <th><?= __('Lokasi Foto') ?></th>
                <td><?= $this->Html->image('img/'.$foto->lokasi_foto,['height'=>'100px']) ?></td>
            </tr>
            <tr>
                <th><?= __('Album') ?></th>
                <td><?= $foto->has('album') ? $this->Html->link($foto->album->nama_album, ['controller' => 'Album', 'action' => 'view', $foto->album->id]) : '' ?></td>
            </tr>
            <tr>
                <th><?= __('User') ?></th>
                <td><?= $foto->has('user') ? $this->Html->link($foto->user->username, ['controller' => 'User', 'action' => 'view', $foto->user->id]) : '' ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($foto->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Tgl Unggahan') ?></th>
                <td><?= h($foto->tgl_unggahan->format('d-m-Y H:i:s')) ?></td>
            </tr>
            <tr>
                <th><?= __('Jumlah Like') ?></th>
                <td><?= h($likecount) ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer d-flex">
        <div class="mr-auto">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $foto->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $foto->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
        <?php if ($userLiked): ?>
            <?= $this->Form->create(null, ['url' => ['controller'=>'Likefoto', 'action' =>'delete', $userLiked->id],'role'=>'form']) ?>
            <div class="ml-auto">
                <?= $this->Form->button(__('🖤'), ['class' => 'btn btn-danger']) ?>
            </div>
            <?= $this->Form->end() ?>
        <?php else: ?>
            <?= $this->Form->create(null, ['url' => ['controller'=>'Likefoto', 'action' =>'add'],'role'=>'form']) ?>
            <div class="ml-auto">
                <?= $this->Form->button(__('❤️'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->control('foto_id', ['type' => 'hidden','value' => $foto->id,'options' => $foto, 'class' => 'form-control']) ?>
                <?= $this->Form->control('user_id', ['value' => $this->Identity->get('id'),'options' => $user, 'class' => 'form-control','type' => 'hidden']) ?>
                <?= $this->Form->control('tgl_like',['value' => $time->i18nFormat('yyyy-MM-dd HH:mm:ss'), 'type' => 'hidden']) ?>
            </div>
            <?= $this->Form->end() ?>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="related related-komentarfoto view card">
    <div class="card-header d-flex">
        <h3 class="card-title"><?= __('Related Komentarfoto') ?></h3>
        <!-- <div class="ml-auto">
            <?= $this->Html->link(__('New Komentarfoto'), ['controller' => 'Komentarfoto', 'action' => 'add', '?' => ['foto_id' => $foto->id]], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= $this->Html->link(__('List Komentarfoto'), ['controller' => 'Komentarfoto', 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </div> -->
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Nama') ?></th>
                <th><?= __('Isi Komentar') ?></th>
                <th><?= __('Tgl Komentar') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php if (empty($foto->komentarfoto)) : ?>
                <tr>
                    <td colspan="6" class="text-muted">
                        <?= __('Komentarfoto record not found!') ?>
                    </td>
                </tr>
            <?php else : ?>
                <?php foreach ($foto->komentarfoto as $komentarfoto) : ?>
                    <tr>
                        <td class="user"><?= h($user[$komentarfoto->user_id])?></td>
                        <td><?= h($komentarfoto->isi_komentar) ?></td>
                        <td><?= h($komentarfoto->tgl_komentar->format('d-m-Y H:i:s')) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'Komentarfoto', 'action' => 'view', $komentarfoto->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Komentarfoto', 'action' => 'edit', $komentarfoto->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Komentarfoto', 'action' => 'delete', $komentarfoto->id], ['class' => 'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $komentarfoto->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
    <?= $this->Form->create(null, ['url' => ['controller'=>'komentarfoto', 'action' =>'add'],'role'=>'form']) ?>
        <div class="card-body">
            <?= $this->Form->control('foto_id', ['value' => $foto->id,'type' => 'hidden','options' => $foto, 'class' => 'form-control']) ?>
            <?= $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->Identity->get('id'), 'class' => 'form-control']) ?>
            <?= $this->Form->control('isi_komentar', ['type' => 'textarea']) ?>
            <?= $this->Form->control('tgl_komentar', ['value' => $time->i18nFormat('yyyy-MM-dd HH:mm:ss'), 'type' => 'hidden']) ?>
        </div>
        <div class="card-footer d-flex">
            <div class="ml-auto">
                <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    <?= $this->Form->end() ?>
</div>

<div class="related related-likefoto view card">
    <div class="card-header d-flex">
        <h3 class="card-title"><?= __('Related Likefoto') ?></h3>
        <!-- <div class="ml-auto">
            <?= $this->Html->link(__('New Likefoto'), ['controller' => 'Likefoto', 'action' => 'add', '?' => ['foto_id' => $foto->id]], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= $this->Html->link(__('List Likefoto'), ['controller' => 'Likefoto', 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </div> -->
    </div>
    <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <tr>
                    <th><?= __('Nama') ?></th>
                    <th><?= __('Tgl Like') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php if (empty($foto->likefoto)) : ?>
                    <tr>
                        <td colspan="5" class="text-muted">
                            <?= __('Likefoto record not found!') ?>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($foto->likefoto as $likefoto) : ?>
                        <tr>
                            <td><?= h($user[$likefoto->user_id])?></td>
                            <td><?= h($likefoto->tgl_like->format('d-m-Y H:i:s')) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Likefoto', 'action' => 'view', $likefoto->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Likefoto', 'action' => 'edit', $likefoto->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Likefoto', 'action' => 'delete', $likefoto->id], ['class' => 'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $likefoto->id)]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>