export default async function universalFillerForUniversalTable(
    defaultArray,
    api,
    Id = null,
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
            dataMap.set(element.descriptionName, {
                value: element.descriptionValue,
                comment: element.commentValue,
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

        return besideArr;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
