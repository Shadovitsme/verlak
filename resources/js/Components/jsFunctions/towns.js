async function adresses() {
    let url =
        'https://gist.githubusercontent.com/gorborukov/0722a93c35dfba96337b/raw/c07da3ce0a429216dca76f96416e0414b7201817/russia';
    // Используем fetch вместо requests
    return fetch(url)
        .then((response) => response.json())
        .then((data) => {
            const townArr = []; // Инициализируем массив
            data.forEach((element) => {
                // В JSON нет поля 'city', используем 'center' для административных центров
                townArr.push(element.city);
            });
            return townArr;
        })
        .catch((error) => {
            console.error('Ошибка:', error);
            return [];
        });
}
let town = await adresses();
export default town;
