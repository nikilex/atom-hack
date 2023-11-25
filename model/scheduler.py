import os
import datetime
import json
from collections import defaultdict


train_folder_path = 'train'

class Oven:
    """ Класс для представления печи """
    def __init__(self, start_temp, working_temps, operations):
        self.start_temp = start_temp  
        self.working_temps = working_temps  
        self.operations = operations  

class Operation:
    """ Класс для представления операции в серии """
    def __init__(self, name, timing, required_temp):
        self.name = name  # Название операции
        self.timing = timing  # Время выполнения операции
        self.required_temp = required_temp  # Требуемая температура для операции

def read_data_from_json(file_path):
    with open(file_path, 'r', encoding='utf-8') as file:
        data = json.load(file)

    # Создаем объекты печи
    ovens = [Oven(oven['start_temp'], oven['working_temps'], oven['operations']) for oven in data['ovens']]

    series_operations = []
    for series in data['series']:
        for operation in series['operations']:
            series_operations.append(Operation(operation['name'], operation['timing'], series['temperature']))

    return ovens, series_operations

def calculate_total_series_time(series_operations, oven):
    """
    Уточненный расчет общего времени выполнения всех операций в серии.

    :param series_operations: список операций в серии
    :param oven: объект печи
    :return: общее время в минутах
    """
    total_time = 0
    previous_temp = oven.start_temp  # oven initial temp
    additional_heating_time = 120  # add. heatting time
    previous_operation = None 

    for operation in series_operations:
        if operation.required_temp != previous_temp:
            total_time += 120 
            previous_temp = operation.required_temp

        if previous_operation in ['prokat', 'kovka'] and operation.name in ['prokat', 'kovka']:
            total_time += additional_heating_time

        total_time += operation.timing
        previous_operation = operation.name

    return total_time

def preprocess_series(series_operations):
    """
    Предварительная обработка серий: определение требуемых операций, их температур и времени выполнения.

    :param series_operations: список операций в серии
    :return: обработанные данные серий
    """
    processed_series = []
    for operation in series_operations:
        processed_series.append({
            'operation_name': operation.name,
            'required_temp': operation.required_temp,
            'timing': operation.timing
        })
    return processed_series

def calculate_equipment_availability(num_ovens):
    """
    Расчет количества доступных прокатников и ковочников на основе количества печей.
    """
    num_sets = (num_ovens // 7) + (1 if num_ovens % 7 != 0 else 0)
    return num_sets, num_sets  # Количество прокатников и ковочников

def can_place_series(series_operations, oven_schedule, current_oven, oven_groups):
    """
    Усовершенствованная проверка возможности размещения серии операций в расписании печи.

    :param series_operations: список операций (объекты Operation) в серии
    :param oven_schedule: текущее расписание печи
    :param current_oven: текущая печь (объект Oven)
    :param oven_groups: группы печей (списки объектов Oven)
    :return: True, если можно разместить серию, иначе False
    """
    group_index = -1
    for i, group in enumerate(oven_groups):
        if current_oven in group:
            group_index = i
            break
    if group_index == -1:
        raise ValueError("Current oven not found in any group")

    for operation in series_operations:
        if operation.name in ['prokat', 'kovka']:
            # Проверка на доступность прокатника/ковочника в группе печей
            for oven in oven_groups[group_index]:
                if any(op.name == operation.name for op in oven_schedule[oven]):
                    return False

    return True

def group_series_by_temperature(processed_series):
    """
    Группировка обработанных серий операций по требуемой температуре.

    :param processed_series: список обработанных данных серий 
    :return: список серий, где каждая серия - это список операций с одинаковой требуемой температурой
    """
    grouped_series = defaultdict(list)
    for operation in processed_series:
        grouped_series[operation['required_temp']].append(operation)

    return list(grouped_series.values())


def distribute_series_to_ovens(processed_series, ovens, oven_groups):
    """
    search of a right distribution.

    :param processed_series: список обработанных данных серий
    :param ovens: список печей
    :param oven_groups: группы печей
    :return: распределение серий по печам
    """
    distribution = defaultdict(list)
    oven_schedule = defaultdict(list)

    # Распределяем серии по печам
    for series in processed_series:
        for oven in ovens:
            if can_place_series(series, oven_schedule, oven, oven_groups):
                distribution[oven].append(series)
                oven_schedule[oven].extend(series)
                break 

    return distribution