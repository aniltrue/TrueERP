n=1;
m=input('Please enter a number : ');

for t=2:m
 k=1;
 
 i=2;
 while(i<=t/2)
  if(rem(t,i)==0)
  k=0;
  break;
  end
  i=i+1;
 endwhile
 
 i=1;
 while(i<=n)
  if(k==1)
  fprintf('%d',t);
  if(i<n)
  fprintf(',');
  end
  end
  i=i+1;
 endwhile
 
 if(k==1)
 fprintf('\n');
 n=n+1;
 end
endfor
