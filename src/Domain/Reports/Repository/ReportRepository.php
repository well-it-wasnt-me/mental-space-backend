<?php

namespace App\Domain\Reports\Repository;

use App\Factory\QueryFactory;
use Cake\Chronos\Chronos;
use DomainException;
use PHPUnit\Exception;

/**
 * Repository.
 */
final class ReportRepository
{
    private QueryFactory $queryFactory;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }





    public function getUserReport(int $user_id): array {
        $paz_id = $this->getPazIDbyUserID($user_id);

        $diary = $this->queryFactory->rawQuery("
            SELECT COUNT(*) AS tot_post,
            DATE(creation_date) AS post_ts
            FROM diaries
            WHERE user_id = $user_id 
            AND DATE(creation_date) >= CURRENT_DATE - INTERVAL 7 DAY
            GROUP BY DATE(creation_date)
        ");

        $comportamento = $this->queryFactory->rawQuery("
            SELECT COUNT(*) AS tot_test,
            DATE(data_compilazione) AS compilazione_ts
            FROM comportamenti
            WHERE paz_id = $paz_id 
            AND DATE(data_compilazione) >= CURRENT_DATE - INTERVAL 7 DAY
            GROUP BY DATE(data_compilazione)
        ");

        $emozioni = $this->queryFactory->rawQuery("
            SELECT COUNT(*) AS tot_test,
            DATE(data_compilazione) AS compilazione_ts
            FROM emozioni
            WHERE paz_id = $paz_id 
            AND DATE(data_compilazione) >= CURRENT_DATE - INTERVAL 7 DAY
            GROUP BY DATE(data_compilazione)
        ");

        $avg = $this->queryFactory->rawQuery("
            SELECT DATE(data_compilazione) AS data_compilazione,
       AVG(rabbia) AS rabbia,
       AVG(paura) AS paura,
       AVG(gioia) AS gioia,
       AVG(colpa) AS colpa,
       AVG(tristezza) AS tristezza,
       AVG(vergogna) AS vergogna,
       AVG(sofferenza_fisica_emotiva) AS sofferenza_fisica_emotiva,
       AVG(abilita_messe_in_pratica) AS abilita_messe_in_pratica,
       AVG(intenzione_abbandono_terapia) AS intenzione_abbandono_terapia,
       AVG(fiducia_cambiamento) AS fiducia_cambiamento
FROM emozioni
WHERE paz_id = $paz_id
  AND DATE(data_compilazione) >= CURRENT_DATE - INTERVAL 7 DAY");

        return ['diario' => $diary, 'comportamento' => $comportamento, 'emozioni' => ['stat'=>$emozioni, 'average'=> $avg]];
    }

    private function getPazIDbyUserID(int $uid){
        return $this->queryFactory->newSelect('patients')
            ->select(['paz_id'])
            ->where("user_id = $uid")
            ->execute()
            ->fetchAll('assoc')[0]['paz_id'];
    }

    public function getDocStat($uid){
        $tot_pat = $this->queryFactory->rawQuery("SELECT COUNT(*) AS tot FROM patients WHERE doc_id = $uid")[0]['tot'];
        $tot_app = $this->queryFactory->rawQuery("SELECT COUNT(*) AS tot FROM calendar WHERE doc_id = $uid AND DATE(start) = CURRENT_DATE")[0]['tot'];
        $tot_money = 0;
        $tot_message = $this->queryFactory->rawQuery("SELECT COUNT(*) AS tot FROM messages WHERE messages.read = 0 AND msg_to = $uid ")[0]['tot'];

        return [
            'tot_paz' => $tot_pat,
            'tot_appm' => $tot_app,
            'tot_money' => $tot_money,
            'unread_msg' => $tot_message
        ];
    }

    public function generazioneReport(array $table, array $raggr, array $assistiti): array {
        for($i=0; $i <= count($table); $i++){
            if($table[$i] === 'diario'){
                if(empty($assistiti)){
                    $cond = "AND user_id IN (SELECT user_id FROM patients WHERE doc_id = " . $_SESSION['user_id'] .")";
                } else {
                    $cond = "AND user_id IN (". implode(",",$assistiti ).")";
                }
                $analisi_diario = $this->queryFactory->rawQuery("SELECT SUM(`total_count`) as `total`, `value`, user_id
FROM (
         SELECT count(*) AS `total_count`, REPLACE(REPLACE(REPLACE(x.`value`,'?',''),'.',''),'!','') as `value`, user_id
         FROM (
                  SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(ExtractValue(t.`content`, '//text()'), ' ', n.n), ' ', -1) `value`, user_id
                  FROM `diaries` t CROSS JOIN
                       (
                           SELECT a.N + b.N * 10 + 1 n
                           FROM
                               (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                              ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                           ORDER BY n
                       ) n
                  WHERE n.n <= 1 + (LENGTH(ExtractValue(t.`content`, '//text()')) - LENGTH(REPLACE(ExtractValue(t.`content`, '//text()'), ' ', '')))
                  ORDER BY `value`
              ) AS x
         GROUP BY x.`value`, x.user_id
     ) AS y
WHERE LENGTH(`value`)>5
  {$cond}
  AND TRIM(`value`) NOT IN ('il',' ','lo','è','e')
GROUP BY `value`
ORDER BY `total` DESC
LIMIT 0,50;");
            }
            elseif($table[$i === 'diagnosi']){
                $analisi_diagnosi = $this->queryFactory->rawQuery("");
            }
        }
        return ['diario' => $analisi_diario, 'diagnosi' => $analisi_diagnosi];
    }
}
