<?php
namespace vbelkin\a2\model;

/**
 * Class AccountCollectionModel
 *
 * @package vbelkin
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */
class AccountCollectionModel extends Model
{
    private $accountIds;

    private $N;

    public function __construct()
    {
        try {
            parent::__construct();
            if (!$result = $this->db->query("SELECT `id` FROM `account`;")) {
                // throw new ...
                throw new connectionException("cannot connect to the database", 0, null);
            }


            $this->accountIds = array_column($result->fetch_all(), 0);
            $this->N = $result->num_rows;


        } catch (connectionException $e) {
            echo $e->displayError();
        }
    }

        /**
     * Get account collection
     *
     * @return \Generator|AccountModel[] Accounts
     */
    public function getAccounts()
    {
        foreach ($this->accountIds as $id) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new AccountModel())->load($id);
        }
    }
}
