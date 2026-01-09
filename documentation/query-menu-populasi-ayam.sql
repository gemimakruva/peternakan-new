SELECT
    k.nama
    , pa.tanggal
    , pa.umur_ayam
    , (
        pa.jumlah_ayam_masuk_kandang 
        - x_total.ayam_mati 
        - x_total.ayam_afkir 
        - x_total.ayam_masuk_karantina 
        + x_total.ayam_keluar_karantina
    ) as ayam_sehat
    , x_total.*
FROM kandang k
LEFT JOIN (
    -- ambil pengadaan ayam terbaru
    SELECT
        kandang_id,
        tanggal,
        umur_ayam,
        jumlah_ayam_masuk_kandang
    FROM pengadaan_ayam
    WHERE tanggal = (SELECT max(pa.tanggal) FROM pengadaan_ayam pa WHERE pa.kandang_id = kandang_id)
) pa ON pa.kandang_id = k.id
LEFT JOIN (
    select 
        total_akumulasi_ayam.kandang_id
        , sum(total_akumulasi_ayam.ayam_mati) ayam_mati
        , sum(total_akumulasi_ayam.ayam_afkir) ayam_afkir
        , sum(total_akumulasi_ayam.ayam_masuk_karantina) ayam_masuk_karantina
        , sum(total_akumulasi_ayam.ayam_keluar_karantina) ayam_keluar_karantina
        , terakhir_diperharui
    from (
        select 
            pa.pipe_id
            , f.kandang_id
            , sum(ayam_mati) as ayam_mati
            , sum(ayam_afkir) as ayam_afkir
            , sum(ayam_masuk_karantina) as ayam_masuk_karantina
            , sum(ayam_keluar_karantina) as ayam_keluar_karantina
            , max(pa.tanggal) as terakhir_diperharui
        from populasi_ayam pa
        inner join pipe p on p.id = pa.pipe_id
        inner join flock f on f.id = p.flock_id
        where pa.tanggal BETWEEN '2025-01-01' and '2025-12-31'
        GROUP BY pa.pipe_id
    ) as total_akumulasi_ayam
    GROUP BY kandang_id, terakhir_diperharui
) x_total on x_total.kandang_id = k.id