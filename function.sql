CREATE TABLE IF NOT EXISTS `function_rel` (
  `id1` int(10) unsigned NOT NULL,
  `id2` int(10) unsigned NOT NULL,
  `relation` decimal(10,5) DEFAULT NULL,
  KEY `id1` (`id1`,`id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO function_rel 
SELECT f.id, function.id,
ROUND(((ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),1,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),1,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),2,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),2,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),3,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),3,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),4,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),4,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),5,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),5,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),6,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),6,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),7,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),7,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),8,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),8,1),20,10))) -
(ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),1,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),1,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),2,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),2,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),3,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),3,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),4,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),4,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),5,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),5,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),6,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),6,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),7,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),7,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),8,1),20,10) - CONV(SUBSTR(LPAD(function.code,8,'0'),8,1),20,10)))) /
(ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),1,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),1,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),2,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),2,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),3,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),3,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),4,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),4,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),5,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),5,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),6,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),6,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),7,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),7,1),20,10)) +
ABS(CONV(SUBSTR(LPAD(f.code,8,'0'),8,1),20,10) + CONV(SUBSTR(LPAD(function.code,8,'0'),8,1),20,10))),5) as relation
FROM Function f JOIN Function

CREATE TABLE IF NOT EXISTS `webservice_rel` (
  `id1` int(10) unsigned NOT NULL,
  `id2` int(10) unsigned NOT NULL,
  `relation` decimal(10,5) DEFAULT NULL,
  KEY `id1` (`id1`,`id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO webservice_rel 
SELECT id1,id2, ROUND(SUM(max_rel)/count(max_rel),5) FROM
(SELECT f1.idwebservice AS id1, f2.idwebservice AS id2, MAX(relation) AS max_rel
FROM function_rel fr
INNER JOIN function f1 ON f1.id = fr.id1
INNER JOIN function f2 ON f2.id = fr.id2
GROUP BY f1.id, f2.idwebservice) AS temp
GROUP BY 1,2

