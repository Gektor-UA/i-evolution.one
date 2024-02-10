<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Eugen',
                'last_name' => 'Qwerty',
                'email' => 'whitefallenangel@gmail.com',
                'phone' => '',
                'messenger' => '12345678911111',
                'birthday' => '1970-01-01 00:00:00',
                'referrer_hash' => 'vnRB7vBS66',
                'twofa_secret' => null,
                'avatar' => 'avatars/6I8Ce7KPlNykDiY3DsNIVbsHaCmlmFauDZpWQkel.png',
                'start_promo' => '2023-08-13 14:09:08',
                'achieved_promo_level' => 'Ambassador+',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 7475,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$Gr/QjDCUMYqiinv4ucRqJ./txrrxKAO/46CyyKI45dq5ByY9Yrp6G',
                'remember_token' => null,
                'created_at' => '2023-03-31 03:14:54',
                'updated_at' => '2023-09-02 14:25:04',
            ],
            [
                'first_name' => 'Henry',
                'last_name' => 'HHHH',
                'email' => 'ik4863534+500@gmail.com',
                'phone' => '0662747161',
                'messenger' => '',
                'birthday' => null,
                'referrer_hash' => 'e19GbkczK6',
                'twofa_secret' => null,
                'avatar' => '',
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 5000,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$St4FzmOHcvb/XCTnW/fWpOBBeVfSzIdM4wHlG.gTLPVqfoidEQZZG',
                'remember_token' => 'H2Ja8JNYly9CbbmW3vjHUhIFy4WtVwtBWZl9EcYNqENK5L70Dd60qBMaW0Hu',
                'created_at' => '2023-03-31 03:18:52',
                'updated_at' => '2023-07-01 00:00:29',
            ],
            [
                'first_name' => 'Ilya',
                'last_name' => 'Alekseew',
                'email' => 'illios7711@gmail.com',
                'phone' => null,
                'messenger' => '1111',
                'birthday' => null,
                'referrer_hash' => 'gdWR84pYNs',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-14 08:07:46',
                'achieved_promo_level' => 'Ambassador+',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 547995,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$MQ9rDvEJiioeRLxfxPDX0eOfcKIjEmaFu21qTMj4N/g2L5Nac6ygK',
                'remember_token' => 'MBccV0XuxavhJvGUCWdTgseMMkllUrkAH3KDuLfAx8PBPL4avJrLzo6aOlkb',
                'created_at' => '2023-03-31 03:41:42',
                'updated_at' => '2023-09-02 14:25:05',
            ],
            [
                'first_name' => 'Alexander',
                'last_name' => 'Gross',
                'email' => 'Alex_the_first88@proton.me',
                'phone' => '+34656620312',
                'messenger' => '@Alex_Garanted',
                'birthday' => '1990-11-14 00:00:00',
                'referrer_hash' => 'TNw2pPZuX5',
                'twofa_secret' => null,
                'avatar' => 'avatars/AZC4cL9jXzLfY2IJ6yqJVyk5aY1B2p4hk6Z4yK70.jpg',
                'start_promo' => '2023-08-14 08:13:05',
                'achieved_promo_level' => 'Ambassador+',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 628481,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$2IZKaYjURcUZDGjPpB89K.MHDXO.vHcg.QIs8VXspQ6pKpd4Bt0Rq',
                'remember_token' => 'Bt2vhH44NMkIrMPzdYObRkudxxdKh6o3pB18jE3GaNmbTWhFScKS6K2dBrog',
                'created_at' => '2023-03-31 09:11:30',
                'updated_at' => '2023-09-02 14:25:06',
            ],
            [
                'first_name' => 'Alex',
                'last_name' => 'Novak',
                'email' => 'InvestTeamGroup7@gmail.com',
                'phone' => null,
                'messenger' => 'https://t.me/AlexYCHT',
                'birthday' => '1983-05-28 00:00:00',
                'referrer_hash' => 'pvzyKUnTeW',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-14 08:08:49',
                'achieved_promo_level' => 'Ambassador+',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 1665074,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$T0LwfQBlsals4d2uLgsy5ORxRGCHKQsfzJF1yHWs8/W0bP/oJklUa',
                'remember_token' => 'OwwFS4Lka9OKSa8628n9hipZvxo5HY4stE1UZR9fNegDqDAGObfl7G9rCNZA',
                'created_at' => '2023-03-31 09:13:32',
                'updated_at' => '2023-09-02 14:25:04',
            ],
            [
                'first_name' => 'Daniel',
                'last_name' => 'Gizmov',
                'email' => 'gizmovdan@gmail.com',
                'phone' => '+7 909 752 0071',
                'messenger' => '',
                'birthday' => '1970-01-01 00:00:00',
                'referrer_hash' => 'mB9zXTQZVS',
                'twofa_secret' => null,
                'avatar' => 'avatars/1gkg2uiOjZQxnAYJHs00VhlwwAS43f5FyChOi8BB.jpg',
                'start_promo' => '2023-08-15 07:48:48',
                'achieved_promo_level' => 'Ambassador+',
                'verification_withdrawal' => 1,
                'verification_tariff_closing' => 1,
                'role_id' => 0,
                'achived_turnover' => 324790,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$t.r2IAiVDI.RAKKlerfAve68Nn2HUZR/MqZADNysV94ruS4aNcXk2',
                'remember_token' => 'BX53uqJZSgxXF4gTLaloVQhriGEhaCotJsXJJ5GE3iuBjUHLgQoqpqscMlxM',
                'created_at' => '2023-03-31 09:19:29',
                'updated_at' => '2023-09-02 14:25:06',
            ],
            [
                'first_name' => 'Nadezhda',
                'last_name' => 'Kozlova',
                'email' => 'kozlova-nadezhda90@mail.ru',
                'phone' => '+7 (901) 588-9278',
                'messenger' => '+79015889278',
                'birthday' => '1990-10-10 00:00:00',
                'referrer_hash' => 'usufX844WE',
                'twofa_secret' => null,
                'avatar' => 'avatars/TmnSlwazUE64buH3sMKI0o7fB4pJpBvwXFKcUt4h.jpg',
                'start_promo' => '2023-08-14 08:13:59',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 12915,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$dKCHAo.ISkWLe0hM4GGLPOx2Pg9keEKyECtGtxMLkeIypfXXb43he',
                'remember_token' => 'Sw295x7RvPm5oJ6Nn2JgAR3XnLb8CO52NEpZXFyAA7NQFQKUhtEtnAvFftVE',
                'created_at' => '2023-03-31 12:18:48',
                'updated_at' => '2023-09-01 00:00:15',
            ],
            [
                'first_name' => 'Marina',
                'last_name' => 'Nilsen',
                'email' => 'mnilsen@mail.ru',
                'phone' => null,
                'messenger' => 'mnilsen@mail.ru',
                'birthday' => null,
                'referrer_hash' => 'GNn8SdM6cG',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 908,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$TmNhMFU/zD4Xga0fsTJ6wuypbgjH2sHuhthLpaEFLhNTaF5QYlPlu',
                'remember_token' => 'Y8L4Cr08P9mt2efauiJ9X38Fg5rfU89N7vwA56cOma5wN2vqQroGuALG7Ml8',
                'created_at' => '2023-03-31 13:38:10',
                'updated_at' => '2023-09-01 00:00:15',
            ],
            [
                'first_name' => 'Zoia',
                'last_name' => 'Upilkova',
                'email' => 'zupilkova@gmail.com',
                'phone' => null,
                'messenger' => 'https://t.me/ZOIA779',
                'birthday' => null,
                'referrer_hash' => 'JU7yDMEn1v',
                'twofa_secret' => null,
                'avatar' => 'avatars/y9KnNtTqjuYPSElD54HR5JiYLBlR3s7TQrFZ5xp7.jpg',
                'start_promo' => '2023-08-14 08:13:09',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 5519,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$aS1j.t1wa32DZOtH1QsviOPJNZn73H9fPbSGdf6y49j3jJf4BWTk.',
                'remember_token' => 'KQupt8cyP0phozpm2otfv7gS4sWPUyYYADGePAsYwg501eGCUOfKBTmFOMhF',
                'created_at' => '2023-03-31 14:58:01',
                'updated_at' => '2023-08-14 08:13:09',
            ],
            [
                'first_name' => 'Marsel',
                'last_name' => 'Shaidullin',
                'email' => 'artistdriller@gmail.com',
                'phone' => '+79828898251',
                'messenger' => '@Uspeshnyi8',
                'birthday' => '1982-12-10 00:00:00',
                'referrer_hash' => '8RKdUKB7Tr',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-14 08:13:34',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 46450,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$/tzRE6F6Qq4Vv4kX7uDSR.LqO.LxG5QRkX9huh3wjmsF9CmV84HFm',
                'remember_token' => 'gsmXTYpM1adbxM8xXA4dRYCoSJ3hVChPn5YQ69dlPaJetuQecRiPQ7ZhlspO',
                'created_at' => '2023-04-01 15:38:28',
                'updated_at' => '2023-09-01 00:00:16',
            ],
            [
                'first_name' => 'Maksim',
                'last_name' => 'Tafintsev',
                'email' => 'm.tafintsev@ukr.net',
                'phone' => null,
                'messenger' => 'https://t.me/max_5591',
                'birthday' => null,
                'referrer_hash' => 'EjupXtNmfJ',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-17 15:44:12',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 2500,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$ZNhpb4FUMVPSdK/MKZsJXutXocXewI1MNiv0.UeFxl8KNsRu3dEia',
                'remember_token' => '1tLWze7CtNF90nfFZ1DIixSAkMd0pwIgpQ4x7uTqqPn8QZmPsiY7elSvwqqS',
                'created_at' => '2023-04-03 06:39:27',
                'updated_at' => '2023-09-01 00:00:17',
            ],
            [
                'first_name' => 'widyship',
                'last_name' => 'widyship',
                'email' => 'widyship@wanadoo.fr',
                'phone' => null,
                'messenger' => 'widyship',
                'birthday' => null,
                'referrer_hash' => 'gxPZwsUJRd',
                'twofa_secret' => null,
                'avatar' => 'avatars/FIrUeWqRXc6beDXPSyvZXjAt1y9hhDo3QznDggMb.png',
                'start_promo' => '2023-08-16 19:46:42',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 12928,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$Hoq7cnUGuHYzUTYihKSvn.UHa8dkxuMoJVGoEFkVz67mIZvt3R9qS',
                'remember_token' => 'L2jlHBUtKCtm4f4KXTkbRKfcD12BIopUvEHxeDj8DhzHXgN1F0rzbuo9HzFt',
                'created_at' => '2023-04-03 11:45:46',
                'updated_at' => '2023-08-16 19:46:42',
            ],
            [
                'first_name' => 'Tatyana',
                'last_name' => 'Tyulpineva',
                'email' => 'jobtatiana3112@gmail.com',
                'phone' => null,
                'messenger' => '+79041917733',
                'birthday' => '1986-12-31 00:00:00',
                'referrer_hash' => 'ywKVLuUbPY',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-15 04:02:46',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 300,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$ggr71GzZWovfDJq92sDYQOIsCH3S4eZ/M4Fv5V8GgfW8mDp6FnSx.',
                'remember_token' => null,
                'created_at' => '2023-04-04 10:31:54',
                'updated_at' => '2023-08-15 04:02:46',
            ],
            [
                'first_name' => 'Maryna',
                'last_name' => 'Vykhryst',
                'email' => 'marinavykhryst@gmail.com',
                'phone' => null,
                'messenger' => 'marinavykhryst@gmail.com',
                'birthday' => null,
                'referrer_hash' => 'cBb3EmGwJv',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 6142,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$xXQi2eikADi67wu7TFQ/N.RMfd/SeG3PjXZhYrDEWql0denO/h22i',
                'remember_token' => null,
                'created_at' => '2023-04-08 14:56:40',
                'updated_at' => '2023-09-01 00:00:17',
            ],
            [
                'first_name' => 'Timur',
                'last_name' => 'Gazinurovich',
                'email' => 'utaliev001@gmail.com',
                'phone' => null,
                'messenger' => 'utaliev001',
                'birthday' => null,
                'referrer_hash' => '2YswZube6B',
                'twofa_secret' => 'ICVQ4WCOYFZ6UY53',
                'avatar' => 'avatars/T2oGDLhRVbxwjHu66gSGCz0AA6YCJCFKCUwYYaMk.jpg',
                'start_promo' => '2023-08-14 08:16:00',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 4605,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$vRATNHMnzw7ILQJ6iDm.ROZTnxM1KjdXL7ntaDD.rV1L/HJmnFttK',
                'remember_token' => 'b9QRiJJcUPxRnCskG71Scwp4u8utpfgqTdTbXEQpVGhtBSGbno5GPJF8HHyR',
                'created_at' => '2023-04-10 04:09:53',
                'updated_at' => '2023-09-02 14:25:07',
            ],
            [
                'first_name' => 'Yestay',
                'last_name' => 'Keshilbayev',
                'email' => 'lejoybottrade24@gmail.com',
                'phone' => '87014967409',
                'messenger' => 'Bitcoin_Yestay',
                'birthday' => '1957-11-06 00:00:00',
                'referrer_hash' => 'z3MNNevW9F',
                'twofa_secret' => 'YIVX7GNXHMU3SCH5',
                'avatar' => 'avatars/zt6cVshK2nbjMRE17tXXXsn9LgQ2jHQxnZS26dvH.jpg',
                'start_promo' => '2023-08-14 05:06:34',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 1,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 8190,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$PIBj7dvVKodJmeqllB9GX.khwJ45qw/jlo2VdVf2gZiikYJ36xFtO',
                'remember_token' => 'n2kW6v3wpPVoXjfY1Uxt3sj9LhDgPlmrOo9FzpFTjLnsarODFpprex1vLlaY',
                'created_at' => '2023-04-10 07:37:35',
                'updated_at' => '2023-09-01 00:00:18',
            ],
            [
                'first_name' => 'VALENTYN',
                'last_name' => 'PASHKEVYCH',
                'email' => 'mr.forbes@zoho.com',
                'phone' => '+380503103416',
                'messenger' => 'https://t.me/VPashkevych',
                'birthday' => '1965-03-27 00:00:00',
                'referrer_hash' => 'BH3v9eu8An',
                'twofa_secret' => 'QICIPZSRT42DEY3R',
                'avatar' => 'avatars/fYBdF54ugrjN3D2Ss2tHzQtNvq9ieJPbB7VclOco.jpg',
                'start_promo' => '2023-08-13 16:21:54',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 76006,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$qIgTbuE0xXQJIQwFh4ZTreest4zNrLX2byKKUNmJ5d57XuPK47gxi',
                'remember_token' => 'eZb15dwAHYDcr0eyzxadWp0RZvJVfzP1pxs46knyaXT80NhEDDUdTShCKSP5',
                'created_at' => '2023-04-23 06:57:44',
                'updated_at' => '2023-09-01 00:00:19',
            ],
            [
                'first_name' => 'Makar',
                'last_name' => 'Prudius',
                'email' => 'prudiusmakar1992@gmail.com',
                'phone' => null,
                'messenger' => 'Makar_Prudius',
                'birthday' => '1992-08-03 00:00:00',
                'referrer_hash' => 'WC8PZzFUmc',
                'twofa_secret' => null,
                'avatar' => 'avatars/MqaFNXn3pNFU0vpDl8pV2XLylSX0dLIiA1lzvqKM.png',
                'start_promo' => '2023-08-14 08:12:49',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 193793,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$chc8gUoOQRYNLdpc2K8js.yGZ9q67zUcJtFisvQokwkyrB2ggPJMi',
                'remember_token' => '3p1RcsnrFQKlK6dSQhrNSfK8e2OHncdNY7Q1sOOLRbKeG8W3jflSnj6LcN55',
                'created_at' => '2023-04-28 03:08:17',
                'updated_at' => '2023-09-01 00:00:19',
            ],
            [
                'first_name' => 'Albin',
                'last_name' => 'Makovskiy',
                'email' => 'albincrypt@gmail.com',
                'phone' => '0973973776',
                'messenger' => 'albin_crypt',
                'birthday' => '1997-09-21 00:00:00',
                'referrer_hash' => '7zaFdjr86y',
                'twofa_secret' => null,
                'avatar' => 'avatars/vTwFVC5wQFw07M7moV6qGBh1Azfbsv8mCBGM0Ka3.jpg',
                'start_promo' => '2023-08-17 09:22:11',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 76128,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$GLNjhLg.GZHtKCnOgV5Izu86FSMFIjFsP2dihYFvn513/oNhoOYwK',
                'remember_token' => 'j3BVwKcTZAxzXEBNIgNA0gCtO1QvUuqI2JsMcdqII0dv053wsV5sSBEuRcLs',
                'created_at' => '2023-05-04 07:52:39',
                'updated_at' => '2023-09-02 14:25:07',
            ],
            [
                'first_name' => 'Irina',
                'last_name' => 'SINITSINA (SPB)',
                'email' => 'trade24spb@inbox.ru',
                'phone' => null,
                'messenger' => '@nikitasokol20',
                'birthday' => '1970-01-01 00:00:00',
                'referrer_hash' => 'EAtf75YUWp',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 1800,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$vKggOzhTlgYXwthVZlYzPOv6MkQGulm2t/SC8FpWEHp1CGZt7Nh4q',
                'remember_token' => 'aDOxu6fIU1AkJWkUj3hKplVbY1iS3Y2ZqNAzwa0u0HRjbcIZQk2idBCo3p2g',
                'created_at' => '2023-05-19 03:15:00',
                'updated_at' => '2023-08-22 18:10:29',
            ],
            [
                'first_name' => 'Alena',
                'last_name' => 'Smeliakova',
                'email' => 'elenamlmnew@gmail.com',
                'phone' => null,
                'messenger' => null,
                'birthday' => null,
                'referrer_hash' => 'SKZveSxkKe',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-14 08:13:37',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 93756,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$mCmGgnygkVXCQk9lmNgC7etI9Oya217B6QSH4IImHX9v6zTH9Oh1.',
                'remember_token' => 'x7SeAG53IUmThEtWZNMMoRgyXJQBH2YtKw833grr7EjkdbZjH4FPE0cdqF5y',
                'created_at' => '2023-05-21 11:45:11',
                'updated_at' => '2023-09-02 14:25:07',
            ],
            [
                'first_name' => 'Elena',
                'last_name' => 'Ledovskaya',
                'email' => '2407111@inbox.ru',
                'phone' => '89029407111',
                'messenger' => '+79029407111',
                'birthday' => '1978-03-23 00:00:00',
                'referrer_hash' => '1hxaM75N2Y',
                'twofa_secret' => null,
                'avatar' => 'avatars/7OExBTusUIU6A3gkkbKGUozOwT62rTgbl6UhTStl.jpg',
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 1201,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$xlj9jFl/BvogaCy3tgsmUuAzHnp/uNvB1km7TPGUMMDe/WJlpBMyS',
                'remember_token' => '7eiTt6JHEmrFvJBz9JRInRbeCAJ5YsgLJ1MoSqu6snHHBNRmUMsOT741Z4AI',
                'created_at' => '2023-05-27 13:22:30',
                'updated_at' => '2023-07-01 00:00:33',
            ],
            [
                'first_name' => 'Ольга',
                'last_name' => 'Агаркова',
                'email' => 'mamedova.olga1983@gmail.com',
                'phone' => null,
                'messenger' => '@olechka_shastie',
                'birthday' => null,
                'referrer_hash' => 'xAEau4yF1c',
                'twofa_secret' => null,
                'avatar' => 'avatars/rwSvSXkTL0QogT4G2EZmM7HbaxLyqAY0eOtSxqqX.jpg',
                'start_promo' => '2023-08-14 08:19:19',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 1800,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$jJpsOGIzGei9eZOt2aLVVOkxnyPFE87elR3xrBifD6AhC2Z955YNO',
                'remember_token' => null,
                'created_at' => '2023-05-30 12:34:47',
                'updated_at' => '2023-08-23 04:08:21',
            ],
            [
                'first_name' => 'Ihor',
                'last_name' => 'Kovalov',
                'email' => 'igkovalov@gmail.com',
                'phone' => '+380633932760',
                'messenger' => 'igkovalov',
                'birthday' => '1971-05-25 00:00:00',
                'referrer_hash' => 'gF7mdV242u',
                'twofa_secret' => null,
                'avatar' => '',
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 4100,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$f1VvB8p/O5UiN0lEtTqp8e.5/VSslB6G99ZPq8Q42sLaRMJkY.KpW',
                'remember_token' => 'Nl6Zg1nQPj6RgqPtXErRFP870VtjPu49kt9p1EV1Pwznm3wfqaTkWwR5OG3S',
                'created_at' => '2023-06-03 04:58:31',
                'updated_at' => '2023-09-01 00:00:20',
            ],
            [
                'first_name' => 'Arifa',
                'last_name' => 'Naibova',
                'email' => 'shnonecoin@gmail.com',
                'phone' => null,
                'messenger' => '994516510884',
                'birthday' => null,
                'referrer_hash' => '4wNNkhWqnU',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-14 08:24:41',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 3510,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$0ZM03vbcue1.0JVk7laQw.DF3mENvKqF8HxnyVqgKDFx4jrQKRal.',
                'remember_token' => null,
                'created_at' => '2023-06-22 15:23:31',
                'updated_at' => '2023-09-01 00:00:20',
            ],
            [
                'first_name' => 'GUZEL',
                'last_name' => 'MIKHAILOVA',
                'email' => '10lyamov88@gmail.com',
                'phone' => null,
                'messenger' => '@Guzelya_ona_samaya',
                'birthday' => null,
                'referrer_hash' => '8VW7pw6pC5',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-14 19:33:44',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 0,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$M.7iNEPYn.Ol3sNnpU7i8.gR/ECwORdUdaHdJjBtmXsWmAlv9Qe.y',
                'remember_token' => null,
                'created_at' => '2023-06-25 09:00:42',
                'updated_at' => '2023-08-14 19:33:44',
            ],
            [
                'first_name' => 'Valentyn',
                'last_name' => 'Larin',
                'email' => 'Mercuryglteam@gmail.com',
                'phone' => '+972528526762',
                'messenger' => '@valentynlarin',
                'birthday' => '1979-08-12 00:00:00',
                'referrer_hash' => 'yjt9CUQzR1',
                'twofa_secret' => 'OJDQPTJGB5FBV7TR',
                'avatar' => null,
                'start_promo' => '2023-08-13 18:24:23',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 4400,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$OjYGCbOn.ygC8zO.K4O.I.ZsCPYL7dFXdZzVZionSpvh09VOwbn8q',
                'remember_token' => null,
                'created_at' => '2023-06-25 15:13:59',
                'updated_at' => '2023-09-01 00:00:20',
            ],
            [
                'first_name' => 'Oksana',
                'last_name' => 'Larina',
                'email' => 'Larinva1979@gmail.com',
                'phone' => null,
                'messenger' => '+380960532277',
                'birthday' => null,
                'referrer_hash' => 'SHDVQ1ZUrf',
                'twofa_secret' => 'DLQEWV3RXA6QOG5G',
                'avatar' => null,
                'start_promo' => '2023-08-13 18:21:09',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 40223,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$4TG5gWkGVPrteU32FFopAObhKh9./88toZHPtcmfK57isB8YncpeO',
                'remember_token' => null,
                'created_at' => '2023-06-25 16:14:41',
                'updated_at' => '2023-09-01 00:00:21',
            ],
            [
                'first_name' => 'Oleh',
                'last_name' => 'Adamskyi',
                'email' => '1111adam1111@gmail.com',
                'phone' => '+380631486445',
                'messenger' => '+380950562752',
                'birthday' => '1975-07-05 00:00:00',
                'referrer_hash' => 'e5zPDLcPUD',
                'twofa_secret' => null,
                'avatar' => 'avatars/WMw9HiqHhXLO0rC83bR6OgtAAc7Hj085tLrtdlBq.jpg',
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 8465,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$HarXg1rV58KoSdE1BJYtIeEYrBcOIbN.Dz3zDYeXwsaPpDwoI.wP2',
                'remember_token' => 'sD3FY39JcFhjFQTinSMZxDXKVWcUEADmAFmowLVakeLIFxgwclzIZ8yl16hX',
                'created_at' => '2023-06-26 13:04:14',
                'updated_at' => '2023-09-01 00:00:21',
            ],
            [
                'first_name' => 'Dmitry',
                'last_name' => 'Drobotenko',
                'email' => 'kriptondmitrij753@gmail.com',
                'phone' => null,
                'messenger' => '@Dmitry_Drobotenko',
                'birthday' => null,
                'referrer_hash' => 'rZrKkt9KKq',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => '2023-08-28 10:03:55',
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 34469,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$kzqJ/Mo3WAJyjo78nQZQSOx1FExYd6eRgy3JwenoqcYjCkGlg0qvi',
                'remember_token' => null,
                'created_at' => '2023-07-03 10:29:37',
                'updated_at' => '2023-09-01 00:00:22',
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'Zykova',
                'email' => 'zykovaanna447319@gmail.com',
                'phone' => null,
                'messenger' => 'savsksya_anna',
                'birthday' => null,
                'referrer_hash' => 'dcyYDnG33A',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 313,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$4fETEZ0BGLoWaSofwrZLaOpKiBxStUQYNXJQ3XbhUv6sd8UP3zrrq',
                'remember_token' => '4k0IbUYfpWD3pNlXVroaTv48bNiv691H6JG1WSnN6x8rG7T97aHl3w8UfdTS',
                'created_at' => '2023-08-02 13:55:47',
                'updated_at' => '2023-09-01 00:00:22',
            ],
            [
                'first_name' => 'Elena',
                'last_name' => 'Pan',
                'email' => 'sochi_pravo@icloud.com',
                'phone' => null,
                'messenger' => '@kleopatra-7777',
                'birthday' => null,
                'referrer_hash' => 'VGXYT21J7d',
                'twofa_secret' => null,
                'avatar' => null,
                'start_promo' => null,
                'achieved_promo_level' => '',
                'verification_withdrawal' => 0,
                'verification_tariff_closing' => 0,
                'role_id' => 0,
                'achived_turnover' => 0,
                'is_ambassador' => 1,
                'ambassador_date' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$1MpxhMe64FSannQsmu5r4uTLW/kIr27vxGkESc4n3YfTq.6tNO9Ve',
                'remember_token' => 'ChOYwjRs34jSZsrQjwn7vQbGmRgCSdSMsHbMDgxRWLF3x6oqKNaz38sZ5T8u',
                'created_at' => '2023-08-28 11:14:45',
                'updated_at' => '2023-08-29 05:42:07',
            ],
        ]);
    }
}
