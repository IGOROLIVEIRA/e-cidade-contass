begin;

DELETE FROM updatedb WHERE codscript NOT IN (SELECT MAX(codscript) As IdMaximo FROM updatedb GROUP BY nomescript);

commit;
