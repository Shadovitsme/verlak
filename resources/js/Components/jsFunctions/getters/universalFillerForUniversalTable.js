export default async function universalFillerForUniversalTable(
    defaultArray,
    api,
    Id,
) {
    try {
        const response = await fetch(api, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Id: Id,
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        // Создаем Map для быстрого доступа к данным из ответа
        const dataMap = new Map();
        data.forEach((element) => {
            dataMap.set(element.name, {
                value: element.value,
                comment: element.comment,
            });
        });

        // Формируем результат, проходя по всем элементам elevatorArrNames
        const besideArr = defaultArray.map((name) => {
            if (dataMap.has(name)) {
                const item = dataMap.get(name);
                return [name, item.value, item.comment];
            }
            return [name, '-', '-'];
        });
        console.log(besideArr);
        return besideArr;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
