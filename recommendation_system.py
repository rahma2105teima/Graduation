import pandas as pd
import json
from collections import Counter
import os
import sys



# Read the CSV file into a DataFrame
# df = pd.read_csv('storage/app/recommendation_dataset.csv')
df = pd.read_csv('C:/Users/Alaa/Desktop/try/signlogin/storage/app/recommendation_dataset.csv')


def recommend_areas(origin, destination, top_n=3):
    locations = df[(df['Origin'] == origin) & (df[destination].notnull())][destination]
    counter = Counter(locations)
    top_areas = [area for area, _ in counter.most_common(top_n)]
    return top_areas

def recommend_areas_with_most_tenants(user_origin, user_destination, top_n=3):
    recommended_areas = recommend_areas(user_origin, user_destination, top_n)
    return recommended_areas


# #
# user_origin = input("Enter your origin: ")
# user_destination = input("Enter your destination: ")

# Retrieve the origin and destination from the command-line arguments
user_origin = sys.argv[1]
user_destination = sys.argv[2]
# Get the recommended areas
recommended_areas = recommend_areas_with_most_tenants(user_origin, user_destination)

# #
# # Convert the output to a JSON string
output_json = json.dumps(recommended_areas)


# #
# # Write the JSON string to a file
output_file = open('recommendation_output.json', 'w')
output_file.write(output_json)
output_file.close()


# # to know where the json file saved

# current_directory = os.getcwd()
# print("Current working directory:", current_directory)

# Print the path of the saved JSON file
current_directory = os.getcwd()
output_file_path = os.path.join(current_directory, 'recommendation_output.json')
# print("JSON file saved at and sorry i am useless:", output_file_path)
# print("i am useless")
print(recommended_areas)
# first=recommended_areas[0]
# second=recommended_areas[1]
# third=recommended_areas[2]
# print('first',first)
# print(second)
# print(third)
# test something useless like me:

# with open('path_to_file/person.json') as f:
#   data = json.load(f)

# print(data)