{* Страница продукта*}

<h3>{$rsProduct['name']}</h3>

<img width="400px" src="/images/products/{$rsProduct['image']}">
  <p>  Стоимость: {$rsProduct['price']} тг</p>

<a href="#" class="removeCart_{$rsProduct['id']} hideme" {if !$itemInCart}class="hideme"{/if} onClick="removeFromCart({$rsProduct['id']}); return false" alt="remove from cart">Удалить из корзины</a>
<a href="#" class="addCart_{$rsProduct['id']}" {if $itemInCart}class="hideme"{/if} onClick="addToCart({$rsProduct['id']}); return false; " alt="add to cart">Добавить в корзину</a>

<p> Описание: </br> {$rsProduct['description']}</p>

{*{d($rsProduct)}*}