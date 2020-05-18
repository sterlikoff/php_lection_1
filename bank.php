<?php

abstract class BankCard
{

  public $number;
  public $dateMonth;
  public $dateYear;
  public $CVC;
  public $ownerName;

  protected $balance = 0.0;

  /**
   * BankCard constructor.
   *
   * @param $number
   * @param $dateMonth
   * @param $dateYear
   * @param $CVC
   * @param $ownerName
   */
  public function __construct($number, $dateMonth, $dateYear, $CVC, $ownerName) {
    $this->number = $number;
    $this->dateMonth = $dateMonth;
    $this->dateYear = $dateYear;
    $this->CVC = $CVC;
    $this->ownerName = $ownerName;
  }


  public function getBalance() {
    return $this->balance;
  }

  public abstract function pay($amount);
  public abstract function debit($amount);

}

class VipCard extends CreditCard {



}

class DebitCard extends BankCard {

  /**
   * DebitCard constructor.
   *
   * @param $number
   * @param $dateMonth
   * @param $dateYear
   * @param $CVC
   * @param $ownerName
   * @param $balance
   */
  public function __construct($number, $dateMonth, $dateYear, $CVC, $ownerName, $balance) {

    $this->balance = $balance;
    parent::__construct($number, $dateMonth, $dateYear, $CVC, $ownerName);

  }


  /**
   * @param $amount
   */
  public function pay($amount) {
    $this->balance += $amount;
  }

  /**
   * @param float $amount
   *
   * @throws Exception
   */
  public function debit($amount) {

    if ($this->balance >= $amount) {
      $this->balance -= $amount;
    } else {
      throw new Exception("Недостаточный баланс.");
    }

  }

}

class CreditCard extends BankCard {

  public $limit;

  /**
   * CreditCard constructor.
   *
   * @param $number
   * @param $dateMonth
   * @param $dateYear
   * @param $CVC
   * @param $ownerName
   * @param $limit
   */
  public function __construct($number, $dateMonth, $dateYear, $CVC, $ownerName, $limit) {

    $this->limit = $limit;
    parent::__construct($number, $dateMonth, $dateYear, $CVC, $ownerName);

  }

  /**
   * @param float $amount
   *
   * @throws Exception
   */
  public function debit($amount) {

    if ($this->balance - $amount > -$this->limit) {
      $this->balance -= $amount;
    } else {
      throw new Exception("Превышен лимит карты");
    }

  }

  /**
   * @param float $amount
   *
   * @throws Exception
   */
  public function pay($amount) {

    if ($this->balance + $amount <= 0) {
      $this->balance += $amount;
    } else {
      throw new Exception("У кредитной карты не может быть положительного баланса.");
    }

  }

}

$card = new CreditCard("1", 12,22, 132, "Ivanov Ivan", 50000);

$card->debit(49000);
$card->pay(40000);
var_dump($card->getBalance());