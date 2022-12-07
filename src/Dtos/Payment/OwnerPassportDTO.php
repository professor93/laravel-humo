<?php
/**
 * Date: 9/29/2022
 * Time: 12:12 PM
 */

namespace Uzbek\LaravelHumo\Dtos\Payment;

class OwnerPassportDTO
{
    public function __construct(
        public string      $serial_no,
        public string      $id_card,
        public string      $first_name,
        public string      $surname,
        public string|null $middle_name = null,
        public string|null $nationality = null,
        public string|null $doc_type = null,
        public string|null $doc_validthrough = null,
        public string|null $person_code = null,
        public string|null $birth_date = null
    )
    {
        $this->nationality = substr($nationality, 0, 3);
        $this->doc_type = substr($doc_type, 0, 3);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $arr = [
            'sender_serial_no' => $this->serial_no,
            'sender_id_card' => $this->id_card,
            'sender_first_name' => $this->first_name,
            'sender_surname' => $this->surname,
        ];

        if (!empty($this->middle_name)) $arr['sender_middle_name'] = $this->middle_name;
        if (!empty($this->nationality)) $arr['sender_nationality'] = $this->nationality;
        if (!empty($this->doc_type)) $arr['sender_doc_type'] = $this->doc_type;
        if (!empty($this->doc_validthrough)) $arr['sender_doc_validthrough'] = $this->doc_validthrough;
        if (!empty($this->person_code)) $arr['sender_person_code'] = $this->person_code;
        if (!empty($this->birth_date)) $arr['sender_birth_date'] = $this->birth_date;

        return $arr;
    }
}
