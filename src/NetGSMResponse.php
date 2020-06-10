<?php

namespace NotificationChannels\Netgsm;

class NetGSMResponse
{
    /**
     * The read response of SMS message request..
     *
     * @var array
     */
    private $responseAttributes = [];

    /**
     * The NetGSM error codes.
     *
     * @var array
     */
    private static $statuses = [
        '00' => 'Mesajınız Başarıyla Gönderildi',
        '20' => 'Mesaj metninde ki problemden dolayı gönderilemediğini veya standart maksimum mesaj karakter sayısını geçtiğini ifade eder.',
        '30' => 'Geçersiz kullanıcı adı , şifre veya kullanıcınızın API erişim izninin olmadığını gösterir.
Ayrıca eğer API erişiminizde IP sınırlaması yaptıysanız ve sınırladığınız ip dışında gönderim sağlıyorsanız 30 hata kodunu alırsınız. API erişim izninizi veya IP sınırlamanızı , web arayüzümüzden; sağ üst köşede bulunan ayarlar> API işlemleri menüsunden kontrol edebilirsiniz.',
        '40' => 'Mesaj başlığınızın (gönderici adınızın) sistemde tanımlı olmadığını ifade eder. Gönderici adlarınızı API ile sorgulayarak kontrol edebilirsiniz.',
        '70' => 'Hatalı sorgulama. Gönderdiğiniz parametrelerden birisi hatalı veya zorunlu alanlardan birinin eksik olduğunu ifade eder.',
    ];

    /**
     * Create a message response.
     *
     * @param string $responseBody
     */
    public function __construct($responseBody)
    {
        $this->responseAttributes = $this->readResponseBodyString($responseBody);
    }

    /**
     * Determine if the operation was successful or not.
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return \in_array($this->statusCode(), ['00', '01', '02'], true);
    }

    /**
     * Get the message's transmission id.
     *
     * @return null|string
     */
    public function transmissionId(): ?string
    {
        return $this->responseAttributes['bulk_id'] ?? null;
    }

    /**
     * Get the status code.
     *
     * @return string
     */
    public function statusCode(): string
    {
        return (string) $this->responseAttributes['status_code'];
    }

    /**
     * Get the string representation of the status.
     *
     * @return string
     */
    public function status(): string
    {
        return array_key_exists($this->statusCode(), self::$statuses)
            ? self::$statuses[$this->statusCode()]
            : $this->statusCode();
    }

    /**
     * Read the message response body string.
     *
     * @param $responseBodyString
     *
     * @return array
     */
    private function readResponseBodyString($responseBodyString): array
    {
        if ($responseBodyString === trim($responseBodyString) && false !== strpos($responseBodyString, ' ')) {
            [$statusCode, $bulkId] = preg_split('/\s+/', $responseBodyString);

            $result['status_code'] = $statusCode;
            $result['bulk_id'] = $bulkId;

            return $result;
        }

        $result['status_code'] = $responseBodyString;

        return $result;
    }
}
