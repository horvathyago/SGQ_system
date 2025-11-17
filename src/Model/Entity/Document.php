<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property string $id
 * @property string $filename
 * @property string|null $mime_type
 * @property string|null $storage_path
 * @property string|null $uploader_id
 * @property int|null $tamanho_bytes
 * @property string|null $doc_hash
 * @property string|null $tipo
 * @property string|null $descricao
 * @property bool|null $is_validated
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\UserAccount $uploader
 * @property \App\Model\Entity\DocumentLink[] $document_link
 */
class Document extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'filename' => true,
        'mime_type' => true,
        'storage_path' => true,
        'uploader_id' => true,
        'tamanho_bytes' => true,
        'doc_hash' => true,
        'tipo' => true,
        'descricao' => true,
        'is_validated' => true,
        'created_at' => true,
        'updated_at' => true,
        'uploader' => true,
        'document_link' => true,
    ];
}
