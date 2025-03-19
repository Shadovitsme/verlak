import elevatorDefaultArray from '../default data array/elevatorDefaultArray';

export default async function elevatorFillerForUniversalTable(elevatorData) {
    try {
        const response = await fetch('/getExecElevator', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                adressId: elevatorData.adressId,
                elevatorName: elevatorData.name,
                entrance: elevatorData.entrance,
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
        const besideArr = elevatorArrNames.map((name) => {
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

const elevatorArrNames = elevatorDefaultArray;
