<?php

use Phoenix\Migration\AbstractMigration;

class Initialization extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('access_log', 'log_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('log_id', 'integer', ['autoincrement' => true])
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('ip', 'string', ['null' => true, 'length' => 100])
            ->addColumn('browser', 'string', ['null' => true, 'length' => 100])
            ->addColumn('os', 'text', ['null' => true])
            ->addColumn('location', 'string', ['null' => true, 'length' => 100])
            ->addColumn('ts', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $this->table('annotation', 'ann_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('ann_id', 'integer', ['autoincrement' => true])
            ->addColumn('creation_date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('annotation', 'text', ['null' => true])
            ->addColumn('doc_id', 'integer', ['null' => true])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->create();

        $this->table('assignment_diagnosis', 'assd_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('assd_id', 'integer', ['autoincrement' => true])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->addColumn('dsm_id', 'integer', ['null' => true])
            ->create();

        $this->table('behaviours', 'cmp_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('cmp_id', 'integer', ['autoincrement' => true])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->addColumn('selfharm_acts', 'text', ['null' => true])
            ->addColumn('suicidal_attempts', 'text', ['null' => true])
            ->addColumn('alcohol_use', 'text', ['null' => true])
            ->addColumn('assunzione_droghe', 'text', ['null' => true])
            ->addColumn('illegal_drug_use', 'text', ['null' => true])
            ->addColumn('binge_eating', 'text', ['null' => true])
            ->addColumn('puking', 'text', ['null' => true])
            ->addColumn('submission_date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $this->table('calendar', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('doc_id', 'integer', ['null' => true])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->addColumn('title', 'string', ['null' => true, 'length' => 200])
            ->addColumn('label', 'string', ['null' => true, 'length' => 200])
            ->addColumn('start', 'datetime', ['null' => true])
            ->addColumn('end', 'datetime', ['null' => true])
            ->addColumn('allDay', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('event_url', 'string', ['null' => true, 'length' => 200])
            ->addColumn('location', 'string', ['null' => true, 'length' => 200])
            ->addColumn('description', 'text', ['null' => true])
            ->create();

        $this->table('consults', 'con_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('con_id', 'integer', ['autoincrement' => true])
            ->addColumn('recipient', 'string', ['null' => true, 'length' => 200])
            ->addColumn('pin_code', 'string', ['null' => true, 'length' => 16])
            ->addColumn('code', 'string', ['null' => true, 'length' => 44])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->addColumn('state', 'tinyinteger', ['null' => true, 'default' => 1, 'length' => 4, 'comment' => '0 = Inactive 1 = Attivo
'])
            ->addColumn('creation_date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $this->table('diaries', 'diary_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('diary_id', 'integer', ['autoincrement' => true])
            ->addColumn('content', 'text')
            ->addColumn('creation_date', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('user_id', 'integer')
            ->create();

        $this->table('doctors', 'doc_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('doc_id', 'integer', ['autoincrement' => true])
            ->addColumn('doc_name', 'string', ['length' => 35])
            ->addColumn('doc_surname', 'string', ['length' => 45])
            ->addColumn('doc_rag_soc', 'string', ['null' => true, 'length' => 150])
            ->addColumn('doc_tel', 'string', ['null' => true, 'length' => 20])
            ->addColumn('doc_photo', 'text', ['null' => true])
            ->addColumn('doc_hourlyrate', 'integer', ['null' => true])
            ->addColumn('doc_address', 'string', ['null' => true, 'length' => 150])
            ->addColumn('doc_paypal', 'string', ['null' => true, 'length' => 150])
            ->addColumn('doc_piva', 'string', ['null' => true, 'length' => 11])
            ->addColumn('user_id', 'integer')
            ->create();

        $this->table('drugs', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('active_principle', 'string', ['null' => true, 'length' => 200])
            ->addColumn('group_description', 'string', ['null' => true, 'length' => 200])
            ->addColumn('denom', 'string', ['null' => true, 'length' => 200])
            ->addColumn('price', 'string', ['null' => true, 'length' => 200])
            ->create();

        $this->table('drugs_assignment', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('farm_id', 'integer', ['null' => true])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->addColumn('assignment_date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('hourFirstDoubleDose', 'string', ['null' => true, 'length' => 5])
            ->addColumn('hourFirstSingleDose', 'string', ['null' => true, 'length' => 5])
            ->addColumn('hourSecondDoubleDose', 'string', ['null' => true, 'length' => 5])
            ->addColumn('scheduled', 'string', ['null' => true, 'length' => 100])
            ->create();

        $this->table('dsm', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('icd_nine', 'string', ['null' => true, 'length' => 10])
            ->addColumn('icd_ten', 'string', ['null' => true, 'length' => 10])
            ->create();

        $this->table('emotions', 'em_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('em_id', 'integer', ['autoincrement' => true])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->addColumn('doc_id', 'integer', ['null' => true])
            ->addColumn('submission_date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('rage', 'integer', ['null' => true])
            ->addColumn('afraid', 'integer', ['null' => true])
            ->addColumn('joy', 'integer', ['null' => true])
            ->addColumn('guilt', 'integer', ['null' => true])
            ->addColumn('sadness', 'integer', ['null' => true])
            ->addColumn('shame', 'integer', ['null' => true])
            ->addColumn('physical_emotional_suffering', 'integer', ['null' => true])
            ->addColumn('abilities_put_into_practice', 'integer', ['null' => true])
            ->addColumn('intention_leave_therapy', 'integer', ['null' => true])
            ->addColumn('trust_into_changing', 'integer', ['null' => true])
            ->addColumn('note', 'text', ['null' => true])
            ->create();

        $this->table('hack_attempt', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('ip', 'string', ['null' => true, 'length' => 100])
            ->addColumn('browser', 'text', ['null' => true])
            ->addColumn('location', 'text', ['null' => true])
            ->addColumn('other', 'text', ['null' => true])
            ->addColumn('ts', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $this->table('icd', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('code', 'string', ['null' => true, 'length' => 10])
            ->addColumn('description', 'text', ['null' => true])
            ->create();

        $this->table('invoices', 'inv_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('inv_id', 'integer', ['autoincrement' => true])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->addColumn('doc_id', 'integer', ['null' => true])
            ->addColumn('amount', 'integer', ['null' => true])
            ->addColumn('amount_paid', 'integer', ['null' => true])
            ->addColumn('payment_type', 'integer', ['null' => true, 'comment' => '0 paypal 1 stripe 2 bonifico 3 cash'])
            ->addColumn('data_issue', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('data_paid', 'timestamp', ['null' => true])
            ->addColumn('inv_status', 'integer', ['null' => true, 'comment' => '0 unpaid
1 overdraft
2 half paid
3 paid
'])
            ->create();

        $this->table('messages', 'msg_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('msg_id', 'integer', ['autoincrement' => true])
            ->addColumn('msg_from', 'integer', ['null' => true])
            ->addColumn('msg_to', 'integer', ['null' => true])
            ->addColumn('content', 'text', ['null' => true])
            ->addColumn('creation_date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('read', 'tinyinteger', ['null' => true, 'default' => 0, 'length' => 4, 'comment' => '0 to read 1 read'])
            ->create();

        $this->table('mood_trackings', 'trk_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('trk_id', 'integer', ['autoincrement' => true])
            ->addColumn('usr_id', 'integer')
            ->addColumn('mood_id', 'integer')
            ->addColumn('effective_datetime', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('warning_sign', 'text', ['null' => true])
            ->create();

        $this->table('moods', 'mood_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('mood_id', 'integer', ['autoincrement' => true])
            ->addColumn('value', 'text')
            ->addColumn('slogan', 'text', ['null' => true])
            ->addColumn('image', 'text', ['null' => true])
            ->create();

        $this->table('objectives', 'ob_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('ob_id', 'integer', ['autoincrement' => true])
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('obiettivo', 'text', ['null' => true])
            ->addColumn('ts_obiettivo', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $this->table('patients', 'paz_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('paz_id', 'integer', ['autoincrement' => true])
            ->addColumn('name', 'string', ['length' => 45])
            ->addColumn('surname', 'string', ['length' => 75])
            ->addColumn('dob', 'date', ['null' => true])
            ->addColumn('cf', 'string', ['null' => true, 'length' => 16])
            ->addColumn('photo', 'text', ['null' => true])
            ->addColumn('address', 'string', ['null' => true, 'length' => 150])
            ->addColumn('height', 'integer', ['null' => true])
            ->addColumn('weight', 'integer', ['null' => true])
            ->addColumn('notes', 'text', ['null' => true])
            ->addColumn('dsm_id', 'integer', ['null' => true])
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('doc_id', 'integer', ['null' => true])
            ->addColumn('data_inizio_cure', 'date', ['null' => true])
            ->addColumn('telefono', 'string', ['null' => true, 'length' => 20])
            ->addColumn('em_nome', 'string', ['null' => true, 'length' => 150])
            ->addColumn('em_telefono', 'string', ['null' => true, 'length' => 20])
            ->create();

        $this->table('phq9', 'ph_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('ph_id', 'integer', ['autoincrement' => true])
            ->addColumn('paz_id', 'integer', ['null' => true])
            ->addColumn('submission_date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('interest', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('depressed', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('sleep_difficulty', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('tired', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('notso_hungry', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('sense_of_guilt', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('trouble_concentrating', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('movement', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('better_dead', 'tinyinteger', ['null' => true, 'length' => 4])
            ->addColumn('propblems_difficulty', 'tinyinteger', ['null' => true, 'length' => 4])
            ->create();

        $this->table('steps', 'pass_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('pass_id', 'integer', ['autoincrement' => true])
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('steps', 'integer', ['null' => true])
            ->addColumn('data_insert', 'date', ['null' => true])
            ->create();

        $this->table('trackings', 'tracking_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('tracking_id', 'integer', ['autoincrement' => true])
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('coords', 'text', ['null' => true])
            ->addColumn('addr', 'text', ['null' => true])
            ->addColumn('effective_data', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $this->table('users', 'user_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('user_id', 'integer', ['autoincrement' => true])
            ->addColumn('email', 'string', ['null' => true, 'length' => 100])
            ->addColumn('password', 'string', ['length' => 128])
            ->addColumn('user_type', 'integer', ['comment' => '1 Patient 2 Doctor 3 Admin'])
            ->addColumn('reg_date', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('account_status', 'integer', ['default' => 0, 'comment' => '0 to activate 1 active 2 suspended 3 deleted 4 Open to registration'])
            ->addColumn('locale', 'string', ['null' => true, 'default' => 'it_IT', 'length' => 5])
            ->addIndex('email', 'unique', 'btree', 'email')
            ->create();

        $this->table('weight_trackings', 'wtrk_id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_0900_ai_ci')
            ->addColumn('wtrk_id', 'integer', ['autoincrement' => true])
            ->addColumn('usr_id', 'integer')
            ->addColumn('weight', 'integer')
            ->addColumn('effective_datetime', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }

    protected function down(): void
    {
        $this->table('access_log')
            ->drop();

        $this->table('annotation')
            ->drop();

        $this->table('assignment_diagnosis')
            ->drop();

        $this->table('behaviours')
            ->drop();

        $this->table('calendar')
            ->drop();

        $this->table('consults')
            ->drop();

        $this->table('diaries')
            ->drop();

        $this->table('doctors')
            ->drop();

        $this->table('drugs')
            ->drop();

        $this->table('drugs_assignment')
            ->drop();

        $this->table('dsm')
            ->drop();

        $this->table('emotions')
            ->drop();

        $this->table('hack_attempt')
            ->drop();

        $this->table('icd')
            ->drop();

        $this->table('invoices')
            ->drop();

        $this->table('messages')
            ->drop();

        $this->table('mood_trackings')
            ->drop();

        $this->table('moods')
            ->drop();

        $this->table('objectives')
            ->drop();

        $this->table('patients')
            ->drop();

        $this->table('phq9')
            ->drop();

        $this->table('steps')
            ->drop();

        $this->table('trackings')
            ->drop();

        $this->table('users')
            ->drop();

        $this->table('weight_trackings')
            ->drop();
    }
}
