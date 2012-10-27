<?php

class AccountingSymbolModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectAllAccountingSymbol($page = 1) {

        $rp = $this->method->post('rp', 10);
        $sortname = $this->method->post('sortname', 'question_id');
        $sortorder = $this->method->post('sortorder', 'desc');
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $listSelect = "
            public_accounting_symbol.accounting_symbol_id,
            public_accounting_symbol.accounting_symbol_title,
            public_accounting_symbol.accounting_symbol,
            public_accounting_symbol.accounting_symbol_status,
            public_accounting_symbol.accounting_symbol_entry,
            public_accounting_symbol.accounting_symbol_entry_update";

        $prepare = 'SELECT ' . $listSelect . ' FROM public_accounting_symbol';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';
        $prepare .= ' ORDER BY ' . $sortname . ' ' . $sortorder;

        $start = (($page - 1) * $rp);
        $prepare .= ' LIMIT ' . $start . ',' . $rp;

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function countAllAccountingSymbol() {
        $query = $this->method->post('query', false);
        $qtype = $this->method->post('qtype', false);

        $prepare = 'SELECT COUNT(accounting_symbol_id) AS cnt FROM public_accounting_symbol';
        if ($query)
            $prepare .= ' WHERE ' . $qtype . ' LIKE "%' . $query . '%" ';

        $sth = $this->db->prepare($prepare);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $tempCount = $sth->fetchAll();
        $count = $tempCount[0];
        return $count['cnt'];
    }

    public function selectByID($id) {
        $sth = $this->db->prepare('
                            SELECT 
                                public_accounting_symbol.accounting_symbol_id,
                                public_accounting_symbol.accounting_symbol_title,
                                public_accounting_symbol.accounting_symbol,
                                public_accounting_symbol.accounting_symbol_status,
                                public_accounting_symbol.accounting_symbol_entry,
                                public_accounting_symbol.accounting_symbol_entry_update
                            FROM
                                public_accounting_symbol
                            WHERE
                                public_accounting_symbol.accounting_symbol_id = :id');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->bindValue(':id', $id);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function createSave() {

        $title = $this->method->post('title');
        $symbol = $this->method->post('symbol');
        $status = $this->method->post('status');

        $sth = $this->db->prepare('
                    INSERT INTO
                    public_accounting_symbol(
                        accounting_symbol_id,
                        accounting_symbol_title,
                        accounting_symbol,
                        accounting_symbol_status,
                        accounting_symbol_entry,
                        accounting_symbol_entry_update)
                    VALUES(
                        (SELECT IF(
                            (SELECT COUNT(pas.accounting_symbol_id) 
                             FROM public_accounting_symbol AS pas) > 0, 
                                (SELECT pas.accounting_symbol_id 
                                 FROM public_accounting_symbol AS pas 
                                 ORDER BY pas.accounting_symbol_id DESC LIMIT 1) + 1,
                            1)
                        ),
                        :title,
                        :symbol,
                        :status,
                        NOW(),
                        NOW())
                ');

        $sth->bindValue(':title', $title);
        $sth->bindValue(':symbol', $symbol);
        $sth->bindValue(':status', $status);

        return $sth->execute();
    }

    public function updateSave($id = 0) {

        $title = $this->method->post('title');
        $symbol = $this->method->post('symbol');
        $status = $this->method->post('status');

        $sth = $this->db->prepare('
                    UPDATE
                        public_accounting_symbol
                    SET
                        accounting_symbol_title = :title,
                        accounting_symbol = :symbol,
                        accounting_symbol_status = :status,
                        accounting_symbol_entry_update = NOW()
                    WHERE
                        public_accounting_symbol.accounting_symbol_id = :id
                ');

        
        $sth->bindValue(':title', $title);
        $sth->bindValue(':symbol', $symbol);
        $sth->bindValue(':status', $status);
        $sth->bindValue(':id', $id);

        return $sth->execute();
    }

    public function delete() {
        $id = $this->method->post('id', 0);
        $sth = $this->db->prepare('DELETE FROM public_accounting_symbol WHERE public_accounting_symbol.accounting_symbol_id IN (' . $id . ')');
        return $sth->execute();
    }

}