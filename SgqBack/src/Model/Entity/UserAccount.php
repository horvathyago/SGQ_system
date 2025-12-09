<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * UserAccount Entity
 *
 * @property string $id
 * @property string $nome
 * @property string $email
 * @property string $role
 * @property string $password_hash
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 */
class UserAccount extends Entity
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
        'nome' => true,
        'email' => true,
        'role' => true,
        'password_hash' => true,
        'created_at' => true,
        'updated_at' => true,
    ];

    protected function _setPasswordHash($password) // Mude o nome da variável para $password, é mais claro
    {
        // 1. Verifica se a senha está sendo definida
        if (strlen($password) > 0) {
            // 2. CORREÇÃO: Usa o nome da classe correta: DefaultPasswordHasher (sem 'ff')
            // O namespace completo não é necessário porque você o importou no topo.
            return (new DefaultPasswordHasher())->hash($password);
        }
        // Retorna null ou uma string vazia se a senha não for fornecida e não for obrigatória
        return null; 
    }
}
