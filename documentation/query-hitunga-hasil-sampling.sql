SELECT 
    SUM(sbape.bobot_per_kg < 1.17) AS kurang_dari,
    SUM(sbape.bobot_per_kg >= 1.17 AND sbape.bobot_per_kg <= 1.24) AS masuk,
    SUM(sbape.bobot_per_kg > 1.24) AS lebih_dari
FROM sampling_bobot_ayam_per_ekor sbape
JOIN sampling_bobot_ayam sba ON sba.id = sbape.sampling_bobot_ayam_id
WHERE sba.kandang_id = 1;
