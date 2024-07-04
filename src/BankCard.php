<?php

namespace Mitoop\Yzh;

class BankCard
{
    private string $cardNo;

    private string $aliPayNo;

    private string $realName;

    private string $phoneNo;

    private string $idCard;

    private function __construct(public BankCardType $type)
    {
    }

    public function setCardNo(string $cardNo): void
    {
        $this->cardNo = $cardNo;
    }

    public function setAliPayNo(string $aliPayNo): void
    {
        $this->aliPayNo = $aliPayNo;
    }

    public function setRealName(string $realName): void
    {
        $this->realName = $realName;
    }

    public function setPhoneNo(string $phoneNo): void
    {
        $this->phoneNo = $phoneNo;
    }

    public function setIdCard(string $idCard): void
    {
        $this->idCard = $idCard;
    }

    public function getCardNo(): string
    {
        return $this->cardNo;
    }

    public function getAlipayNo(): string
    {
        return $this->aliPayNo;
    }

    public function getRealName(): string
    {
        return $this->realName;
    }

    public function getIdCard(): string
    {
        return $this->idCard;
    }

    public function getPhoneNo(): string
    {
        return $this->phoneNo;
    }

    public static function create(BankCardType $type): self
    {
        return new self($type);
    }
}
