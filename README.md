# Personlib - Personel Yönetim Yazılımı

## Proje Tanımı

Personlib, şirket içi personel yönetimini kolaylaştıran ve iş süreçlerinizi optimize eden yenilikçi bir platformdur. Bu proje kapsamında personel bilgilerinin yönetimi, izin süreçlerinin takibi ve daha birçok yönetimsel işlemin gerçekleştirilmesi hedeflenmiştir.

## Özellikler

- Kullanıcı kayıt ve giriş işlemleri
- Personel bilgileri yönetimi
- İzin talepleri ve takibi
- Şirket ayarları yönetimi

## Kurulum

Bu projeyi kendi lokalinizde çalıştırmak için aşağıdaki adımları izleyebilirsiniz.

### Gereksinimler

- PHP 7.4 veya üstü
- Composer
- MySQL
- Laravel 8.x

### Adımlar

1. Projeyi klonlayın:
    ```sh
    git clone <proje_linki>
    cd proje
    ```

2. Gerekli bağımlılıkları yükleyin:
    ```sh
    composer install
    ```

3. `.env` dosyasını oluşturun:
    ```sh
    cp .env.example .env
    ```

4. .env dosyasını düzenleyerek veritabanı bilgilerinizi girin:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=personel
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

5. Uygulama anahtarını oluşturun:
    ```sh
    php artisan key:generate
    ```

6. Veritabanını oluşturun ve migrasyonları çalıştırın:
    ```sh
    php artisan migrate
    ```

7. Projeyi çalıştırın:
    ```sh
    php artisan serve
    ```

## Kullanım

Proje, üç farklı kullanıcı rolü içermektedir:
- **Yönetici**: Tüm sistem üzerinde tam yetkiye sahiptir.
- **Yönetici Yardımcısı**: Belirli yönetimsel işlemleri gerçekleştirebilir.
- **Çalışan**: Kendi bilgilerini görüntüleyebilir ve izin talebinde bulunabilir.

## Lisans

Bu proje Ahmet Yesevi Üniversitesi, Türkistan Meslek Yüksekokulu. - Osman Ceyhan tarafından gerçekleştirilmiştir.

## Danışman
Dr. Öğr. Üyesi Sami Acar
