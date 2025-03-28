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

        // Формируем результат
        const besideArr = [];
        const processedNames = new Set(); // Для отслеживания обработанных имен

        // Добавляем все элементы из ответа сервера (data), включая кастомные, но только с непустым name
        data.forEach((element) => {
            const name = element.descriptionName;
            // Проверяем, что name не пустой (не null, не undefined, не пустая строка)
            if (name && name.trim() !== '') {
                besideArr.push([
                    name,
                    name,
                    element.descriptionValue,
                    element.commentValue,
                ]);
                processedNames.add(name); // Отмечаем имя как обработанное
            }
        });

        // Затем добавляем недостающие элементы из elevatorArrNames, если их нет в data
        elevatorArrNames.forEach((name) => {
            // Проверяем, что name не пустой и еще не обработан
            if (name && name.trim() !== '' && !processedNames.has(name)) {
                besideArr.push([name, name, '-', '-']);
            }
        });

        return besideArr;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}

const elevatorArrNames = elevatorDefaultArray;
