function words = splitSpaces(text)
  words = [];
  
  j = 1;
  for i = 1:length(text)
    if text(i) == ' '
      word = text(j:i);
      words = [words; word];
      j = i;
    end
  end
  
end
