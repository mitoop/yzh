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

    public function setCardNo(string $cardNo): static
    {
        $this->cardNo = $cardNo;

        return $this;
    }

    public function setAliPayNo(string $aliPayNo): static
    {
        $this->aliPayNo = $aliPayNo;

        return $this;
    }

    public function setRealName(string $realName): static
    {
        $this->realName = $realName;

        return $this;
    }

    public function setPhoneNo(string $phoneNo): static
    {
        $this->phoneNo = $phoneNo;

        return $this;
    }

    public function setIdCard(string $idCard): static
    {
        $this->idCard = $idCard;

        return $this;
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

    public static function create(BankCardType $type): static
    {
        return new self($type);
    }
}
