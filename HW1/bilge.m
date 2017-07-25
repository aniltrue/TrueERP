%% Bilge Maras S009842 Industrial Engineering

n = input('Please enter a number : ');

row = 1;

for i = 2:n
  isPrime = true;
  
  for j = 2:(i / 2)
    if mod(i, j) == 0
      isPrime = false;
      break;
    end
  end
  
  if ~isPrime
    continue;
  end
  
  for j = 1:row
    fprintf('%d', i);
    if j ~= row
      fprintf(',');
    end
  end
  
  fprintf('\n');
  row++;
end
