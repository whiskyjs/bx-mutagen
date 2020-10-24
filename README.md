[![Лицензия](https://img.shields.io/github/license/whiskyjs/bx-mutagen?style=flat-square)](https://github.com/whiskyjs/bx-mutagen/blob/develop/LICENSE.txt)

## BX-Mutagen

Набор классов (плагинов в терминологии пакета) и функций для модификации поведения ядра Bitrix без изменения исходного кода. Proof of concept.

## Список плагинов

* **ComponentInterceptor**

  Позволяет переопределить схему разрешения класса классового компонента по пути, подключать вместо самого класса его наследник-враппер и переопределять его методы.
  
  ```php
   use WJS\Mutagen\Core\Delegation\Delegate;
  
   use WJS\Mutagen\BX\Main\Component\ComponentInterceptorPlugin;
   use WJS\Mutagen\BX\Main\Component\ComponentInterceptorOptions;
   
   class MyDelegate extends Delegate
   {
       /**
        * @bx-delegate
        * @param $arParams
        * @return mixed
        */
       public function onPrepareComponentParams($arParams): array
       {
           return $arParams;
       }
   }
   
   $myDelegate = new MyDelegate();
   
   $options = new ComponentInterceptorOptions(
       $myDelegate,
       // Можем проверить, какие именно классы нужно перехватывать
       fn (string $class) => true
   );
   $interceptor = new ComponentInterceptorPlugin($options);
   $interceptor->plugIn();
  ```

### Лицензия

Apache 2.0.
