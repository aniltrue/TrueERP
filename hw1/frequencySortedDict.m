function sortedDict = frequencySortedDict(dictionary, frequency)
  dictionary = splitSpaces(dictionary);
  sortedDict = '';
  
  for i = 1:length(frequency)
    j = findMax(frequency, i);
    
    temp = frequency(j);
    frequency(j) = frequency(i);
    frequency(i) = temp;
    
    temp = dictionary{j};
    dictionary{j} = dictionary{i};
    dictionary{i} = temp;
  end
  
  for i = 1:length(dictionary)
    sortedDict = [sortedDict ' ' dictionary{i}];
  end
end
